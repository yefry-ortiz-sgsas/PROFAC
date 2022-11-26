<?php

namespace App\Http\Livewire\Vale;

use Livewire\Component;
use DataTables;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\ModelFactura;
use App\Models\ModelCAI;
use App\Models\ModelRecibirBodega;
use App\Models\ModelVentaProducto;
use App\Models\ModelLogTranslados;
use App\Models\ModelParametro;
use App\Models\ModelLista;
use App\Models\ModelCliente;
use App\Models\logCredito;
use App\Models\ModelVale;
use App\Models\User;


class RestarVale extends Component
{
    public $arrayProductos = [];
    public $arrayLogs = [];

    public function render()
    {
        return view('livewire.vale.restar-vale');
    }

    public function listarVales(){
       try {

        $listaVales = DB::SELECT("
        select 

        A.id,
        A.numero_vale,
        FORMAT(A.sub_total,2) as sub_total,
        FORMAT(A.isv,2) as isv,
        FORMAT(A.total,2) as total,
        C.numero_factura,
        C.nombre_cliente,
        A.factura_id,
        A.created_at,
        D.name,
        A.estado_id 
        from vale A
        inner join espera_has_producto B
        on A.id = B.vale_id
        inner join factura C
        on A.factura_id = C.id
        inner join users D
        on A.users_id = D.id
        where A.estado_id <>3
       
        order by A.created_at desc

        ");
        return Datatables::of($listaVales)
                ->addColumn('opciones', function ($vale) {


                    return
                        '<div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                    más</button>
                <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                    <li>
                    <a class="dropdown-item" target="_blank"  onclick="anularVale('.$vale->id.')"> <i class="fa-solid fa-ban text-info"></i> Anular Vale </a>
                    </li>  

                    <li>
                    <a class="dropdown-item" target="_blank"  href=""> <i class="fa-solid fa-file-invoice text-success"></i> Imprimir Vale </a>
                    </li>  

                    <li>
                    <a class="dropdown-item" target="_blank"   onclick="eliminarVale('.$vale->id.')"> <i class="fa-regular fa-trash-can text-danger"></i> Eliminar Vale </a>
                    </li>  
                                        
                </ul>
            </div>';
                })
                ->addColumn('estado', function ($vale) {

                    if($vale->estado_id==1){
                        return '<p class="text-center"><span class="badge badge-danger p-2" style="font-size:0.75rem">Pendiente</span></p>';
                    }else{
                       
                       return  '<p class="text-center"><span class="badge badge-primary p-2" style="font-size:0.75rem">Anulado</span></p>';
                    }
                   
                       
                })
                ->rawColumns(['opciones','estado'])
                ->make(true);
        } catch (QueryException $e) {
            return response()->json([
                'icon' => 'error',
                'text' => 'Ha ocurrido un error al listar los comprobantes de entrega.',
                'title' => 'Erro!',
                'message' => 'Ha ocurrido un error',
                'error' => $e,
            ], 402);
        }



    }

    public function anularVale(Request $request){
           try {
            DB::beginTransaction();
            $listaProductos = DB::SELECT("
            select 
                B.resta_inventario_total,
                B.producto_id,
                B.unidad_medida_venta_id as idUnidadVenta,
                B.precio,
                B.cantidad,
                B.sub_total,
                B.isv,
                B.total,
                C.isv as ivsProducto,             
                D.unidad_venta,
                E.id as idFactura,
                C.nombre
            from vale A
            inner join espera_has_producto B on
            A.id = B.vale_id
            inner join producto C
            on C.id = B.producto_id
            inner join unidad_medida_venta D
            on B.unidad_medida_venta_id = D.id
            inner join factura E
            on A.factura_id = E.id
            where A.id = ".$request->idVale
            );

            $mensaje = "";
            $flag = false;

            foreach($listaProductos as $producto){
                $resultado = DB::SELECTONE("
                select 
                if(sum(cantidad_disponible) is null,0,sum(cantidad_disponible)) as cantidad_disponoble
                from recibido_bodega
                where cantidad_disponible <> 0
                and producto_id = " .$producto->producto_id);
    
                    if ($producto->resta_inventario_total > $resultado->cantidad_disponoble) {
                        $mensaje = $mensaje . "Unidades insuficientes para el producto: <b>" . $producto->nombre ."-"."$producto->producto_id  </b>.";
                        $flag = true;
                    }
            }

            if ($flag) {
                return response()->json([
                    'icon' => "warning",
                    'text' =>  '<p class="text-left">' . $mensaje . '</p>',
                    'title' => 'Advertencia!',
                    'idFactura' => 0,

                ], 200);
            }

            foreach($listaProductos as $producto){
                $this->restarUnidadesInventario(
                    $producto->resta_inventario_total,
                    $producto->producto_id,
                    $producto->idFactura,
                    $producto->idUnidadVenta,
                    $producto->precio,
                    $producto->cantidad,
                    $producto->sub_total,
                    $producto->isv,
                    $producto->total,
                    $producto->ivsProducto,
                    $producto->unidad_venta                
                );    
            }


            ModelVentaProducto::insert($this->arrayProductos);
            ModelLogTranslados::insert($this->arrayLogs);

            $vale =  ModelVale::find($request->idVale);
            $vale->estado_id = 2;
            $vale->save();


            DB::commit();
           return response()->json([
            'icon' => 'success',
            'text' => 'Exito al anular el vale',
            'title' => 'Exito.',
           ],200);
           } catch (QueryException $e) {
            DB::rollback();
           return response()->json([
            'icon' => '',
            'text' => '',
            'title' => '',
            'message' => 'Ha ocurrido un error', 
            'error' => $e,
           ],402);
           }
    }

    public function restarUnidadesInventario($unidadesRestarInv, $idProducto, $idFactura, $idUnidadVenta, $precio, $cantidad, $subTotal, $isv, $total, $ivsProducto, $unidad)
    {
    

            $precioUnidad = $subTotal / $unidadesRestarInv;

            $unidadesRestar = $unidadesRestarInv;//es la cantidad ingresada por el usuario multiplicado por unidades de venta del producto
            $registroResta = 0;
            while (!($unidadesRestar <= 0)) {

                $unidadesDisponibles = DB::SELECTONE("
                        select 
                            id,
                            cantidad_disponible,
                            seccion_id
                        from recibido_bodega 
                        where                       
                            producto_id = " . $idProducto . " and 
                            cantidad_disponible <> 0
                            order by created_at asc
                        limit 1
                        ");


                if ($unidadesDisponibles->cantidad_disponible == $unidadesRestar) {

                    $diferencia = $unidadesDisponibles->cantidad_disponible - $unidadesRestar;
                    $lote = ModelRecibirBodega::find($unidadesDisponibles->id);
                    $lote->cantidad_disponible = $diferencia;
                    $lote->save();

                    $registroResta = $unidadesRestar;
                    $unidadesRestar = $diferencia;

                    $subTotalSecccionado = round(($precioUnidad * $registroResta), 2);
                    $isvSecccionado = round(($subTotalSecccionado * ($ivsProducto / 100)), 2);
                    $totalSecccionado = round(($isvSecccionado + $subTotalSecccionado), 2);

                    $cantidadSeccion = $registroResta / $unidad;
                } else if ($unidadesDisponibles->cantidad_disponible > $unidadesRestar) {

                    $diferencia = $unidadesDisponibles->cantidad_disponible - $unidadesRestar;


                    $lote = ModelRecibirBodega::find($unidadesDisponibles->id);
                    $lote->cantidad_disponible = $diferencia;
                    $lote->save();

                    $registroResta = $unidadesRestar;
                    $unidadesRestar = 0;

                    $subTotalSecccionado = round(($precioUnidad * $registroResta), 2);
                    $isvSecccionado = round(($subTotalSecccionado * ($ivsProducto / 100)), 2);
                    $totalSecccionado = round(($isvSecccionado + $subTotalSecccionado), 2);

                    $cantidadSeccion = $registroResta / $unidad;
                } else if ($unidadesDisponibles->cantidad_disponible < $unidadesRestar) {

                    $diferencia = $unidadesRestar - $unidadesDisponibles->cantidad_disponible;
                    $lote = ModelRecibirBodega::find($unidadesDisponibles->id);
                    $lote->cantidad_disponible = 0;
                    $lote->save();

                    $registroResta = $unidadesDisponibles->cantidad_disponible;
                    $unidadesRestar = $diferencia;

                    $subTotalSecccionado = round(($precioUnidad * $registroResta), 2);
                    $isvSecccionado = round(($subTotalSecccionado * ($ivsProducto / 100)), 2);
                    $totalSecccionado = round(($isvSecccionado + $subTotalSecccionado), 2);

                    $cantidadSeccion = $registroResta / $unidad;
                };


                array_push($this->arrayProductos, [
                    "factura_id" => $idFactura,
                    "producto_id" => $idProducto,
                    "lote" => $unidadesDisponibles->id,
                    "seccion_id" => $unidadesDisponibles->seccion_id,
                    "numero_unidades_resta_inventario" => $registroResta, //el numero de unidades que se va restar del inventario pero en unidad base 
                    "sub_total" => $subTotal,
                    "isv" => $isv,
                    "total" => $total,
                    "resta_inventario_total" => $unidadesRestarInv, //Es la cantidad que ingresa el usuario para la venta 
                    "unidad_medida_venta_id" => $idUnidadVenta, //la unidad de medida que selecciono el usuario para la venta
                    "precio_unidad" => $precio, // precio de venta ingresado por el usuario
                    "cantidad" => $cantidad, //cantidad ingresada por el usuario 
                    "cantidad_s" => $cantidadSeccion, //la unidad que se resta del inventario  pero convertida a la unidad de venta seleccionada por el usuario
                    "cantidad_para_entregar" => $registroResta, //las unidades basica 1 disponible para vale
                    "sub_total_s" => $subTotalSecccionado,
                    "isv_s" => $isvSecccionado,
                    "total_s" => $totalSecccionado,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);

                array_push($this->arrayLogs, [
                    "origen" => $unidadesDisponibles->id,
                    "factura_id" => $idFactura,
                    "cantidad" => $registroResta,
                    "unidad_medida_venta_id"=>$idUnidadVenta,
                    "users_id" => Auth::user()->id,
                    "descripcion" => "Venta de producto",
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            };

            //dd($arrarVentasProducto);   
            //ModelVentaProducto::created($arrarVentasProducto);  
            //ModelVentaProducto::insert($arrarVentasProducto);  
            //DB::table('venta_has_producto')->insert($arrarVentasProducto); 


            return;

    }

    public function eliminarVale(Request $request){
       try {
        DB::beginTransaction();
        $vale = ModelVale::find($request->idVale);
        $vale->estado_id = 5;
        $vale->comentario_eliminar = $request->motivo;
        $vale->save();

        $factura = ModelFactura::find($vale->factura_id);        
        $factura->total = ROUND($factura->total - $vale->total,2);
        $factura->isv = Round($factura->isv -  $vale->isv,2);
        $factura->sub_total = ROUND($factura->sub_total - $vale->sub_total,2);
        $factura->save();
        DB::commit();
       return response()->json([
        'icon' => 'success',
        'text' => 'Vale Eliminado con éxito.',
        'title' => 'Exito!',
       ],200);
       } catch (QueryException $e) {
        DB::rollback();
       return response()->json([
        'icon' => 'error',
        'text' => 'Ha ocurrido un error al eliminar el vale.',
        'title' => 'Error!',
        'message' => 'Ha ocurrido un error', 
        'error' => $e,
       ],402);
       }
    }
}
