<?php

namespace App\Http\Livewire\ComprovanteEntrega;

use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use Validator;
use PDF;
use Luecano\NumeroALetras\NumeroALetras;

use App\Models\ModelComprovanteEntrega;
use App\Models\ModelComprovanteHasProducto;
use App\Models\ModelRecibirBodega;
use App\Models\ModelVentaProducto;
use App\Models\ModelLogTranslados;


class CrearComprovante extends Component
{
    
    public $arrayProductos = [];
    public $arrayLogs = [];

    public function render()
    {
        return view('livewire.comprovante-entrega.crear-comprovante');
    }

    public function clientesObtener(Request $request)
    {

     
            $listaClientes = DB::SELECT("
            select 
                id,
                nombre as text
            from cliente
                where estado_cliente_id = 1
                                      
                and  (id LIKE '%" . $request->search . "%' or nombre Like '%" . $request->search . "%') limit 15
                    ");
        

                    return response()->json([
                        "results" => $listaClientes,
                    ], 200);
    }


    public function guardarComprovante(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'fecha_vencimiento' => 'required',            
            'subTotalGeneral' => 'required',
            'isvGeneral' => 'required',
            'totalGeneral' => 'required',
            'arregloIdInputs' => 'required',
            'numeroInputs' => 'required',
            'seleccionarCliente' => 'required',
            'nombre_cliente_ventas' => 'required',
            'tipoPagoVenta' => 'required',
            'bodega' => 'required',  
            'comentario'=>'required'          
      
            
       



        ]);

         //dd($request->all());

        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al crear la compra.',
                'errors' => $validator->errors()
            ], 406);
        }

           //dd($request->all());
           $arrayInputs = [];
           $arrayInputs = $request->arregloIdInputs;
           $arrayProductosVentas = [];
   
           $mensaje = "";
           $flag = false;
   
           //comprobar existencia de producto en bodega
           for ($j = 0; $j < count($arrayInputs); $j++) {
   
               $keyIdSeccion = "idSeccion" . $arrayInputs[$j];
               $keyIdProducto = "idProducto" . $arrayInputs[$j];
               $keyRestaInventario = "restaInventario" . $arrayInputs[$j];
               $keyNombre = "nombre" . $arrayInputs[$j];
               $keyBodega = "bodega" . $arrayInputs[$j];
   
               $resultado = DB::selectONE("select 
               if(sum(cantidad_disponible) is null,0,sum(cantidad_disponible)) as cantidad_disponoble
               from recibido_bodega
               where cantidad_disponible <> 0
               and producto_id = " . $request->$keyIdProducto . "
               and seccion_id = " . $request->$keyIdSeccion);
   
               if ($request->$keyRestaInventario > $resultado->cantidad_disponoble) {
                   $mensaje = $mensaje . "Unidades insuficientes para el producto: <b>" . $request->$keyNombre . "</b> en la bodega con sección :<b>" . $request->$keyBodega . "</b><br><br>";
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

           $tipoVenta = DB::SELECTONE("select tipo_cliente_id from cliente where id =".$request->seleccionarCliente);

        try {




            // $numeroComprovante= DB::SELECTONE("
            // select 
            // @contador:=count(id), 
            // if(@contador = 0, 1 , @contador) as contador,
            // YEAR(NOW()) as anio

            // from comprovante_entrega
            // ");
            $numeroComprovante= DB::SELECTONE("
            select 
            id,
            YEAR(NOW()) as anio

            from comprovante_entrega
            order by id desc
            ");
            if(empty($numeroComprovante->id)){
                $suma= 1;             
                $numeroOrden = date('Y')."-".$suma;            
            }else{
                $suma= $numeroComprovante->id+1;     
                $numeroOrden = $numeroComprovante->anio."-".$suma;        
            }          
           


            DB::beginTransaction();

            $comprovante = new ModelComprovanteEntrega;
            $comprovante->numero_comprovante =  $numeroOrden;
            $comprovante->nombre_cliente =  $request->nombre_cliente_ventas;
            $comprovante->RTN =  $request->rtn_ventas;
            $comprovante->fecha_emision = $request->fecha_emision;
            $comprovante->fecha_vencimineto = $request->fecha_vencimiento; 
            $comprovante->sub_total = $request->subTotalGeneral;
            $comprovante->isv =  $request->isvGeneral;
            $comprovante->total =  $request->totalGeneral;
            $comprovante->cliente_id =  $request->seleccionarCliente;
            $comprovante->tipo_venta_id =  $tipoVenta->tipo_cliente_id;
            $comprovante->arregloIdInputs =  json_encode($request->arregloIdInputs);
            // $comprovante->vendedor =  $numeroOrden;
            $comprovante->comentario = $request->comentario;
            $comprovante->users_id =  Auth::user()->id;
            $comprovante->numeroInputs =  $request->numeroInputs;
            $comprovante->estado_id =  1;
            $comprovante->save();

            for ($i = 0; $i < count($arrayInputs); $i++) {

                $keyRestaInventario = "restaInventario" . $arrayInputs[$i];

                $keyIdSeccion = "idSeccion" . $arrayInputs[$i];
                $keyIdProducto = "idProducto" . $arrayInputs[$i];
                $keyIdUnidadVenta = "idUnidadVenta" . $arrayInputs[$i];
                $keyPrecio = "precio" . $arrayInputs[$i];
                $keyCantidad = "cantidad" . $arrayInputs[$i];
                $keySubTotal = "subTotal" . $arrayInputs[$i];
                $keyIsv = "isvProducto" . $arrayInputs[$i];
                $keyTotal = "total" . $arrayInputs[$i];
                $keyISV = "isv" . $arrayInputs[$i];
                $keyunidad = 'unidad' . $arrayInputs[$i];

                $restaInventario = $request->$keyRestaInventario;
                $idSeccion = $request->$keyIdSeccion;
                $idProducto = $request->$keyIdProducto;
                $idUnidadVenta = $request->$keyIdUnidadVenta;
                $ivsProducto = $request->$keyISV;
                $unidad = $request->$keyunidad;

                $precio = $request->$keyPrecio;
                $cantidad = $request->$keyCantidad;
                $subTotal = $request->$keySubTotal;
                $isv = $request->$keyIsv;
                $total = $request->$keyTotal;

                $this->restarUnidadesInventario($restaInventario, $idProducto, $idSeccion, $comprovante->id, $idUnidadVenta, $precio, $cantidad, $subTotal, $isv, $total, $ivsProducto, $unidad);
            };

            ModelComprovanteHasProducto::insert($this->arrayProductos);
            ModelLogTranslados::insert($this->arrayLogs);


            DB::commit();
            return response()->json([
                'icon' => "success",
                'text' =>  '
                <div class="d-flex justify-content-between">
                   
                <a class="dropdown-item" target="_blank"  href="/orden/entrega/facturar/' . $comprovante->id . '"> <i class="fa-solid fa-print text-success"></i> Imprimir Comprobante </a>
                   
                </div>',
                'title' => 'Exito!',
                'idComprobante' => $comprovante->id,
                

            ], 200);
        } catch (QueryException $e) {
            DB::rollback();

            return response()->json([
                'error' => $e,
                'icon' => "error",
                'text' => 'Ha ocurrido un error.',
                'title' => 'Error!',
                'idFactura' => $comprovante->id,
            ], 402);
        }
    }

    public function restarUnidadesInventario($unidadesRestarInv, $idProducto, $idSeccion, $idOrdenEntrega, $idUnidadVenta, $precio, $cantidad, $subTotal, $isv, $total, $ivsProducto, $unidad)
    {
       

            $precioUnidad = $subTotal / $unidadesRestarInv;

            $unidadesRestar = $unidadesRestarInv;
            $registroResta = 0;
            while (!($unidadesRestar <= 0)) {

                $unidadesDisponibles = DB::SELECTONE("
                        select 
                            id,
                            cantidad_disponible
                        from recibido_bodega
                            where seccion_id = " . $idSeccion . " and 
                            producto_id = " . $idProducto . " and 
                            cantidad_disponible <>0
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
                    "comprovante_id" => $idOrdenEntrega,
                    "producto_id" => $idProducto,
                    "lote_id" => $unidadesDisponibles->id,
                    "seccion_id" => $idSeccion,
                    "numero_unidades_resta_inventario" => $registroResta,
                    "sub_total" => $subTotal,
                    "isv" => $isv,
                    "total" => $total,
                    "resta_inventario_total" => $unidadesRestarInv,
                    "unidad_medida_venta_id" => $idUnidadVenta,
                    "precio_unidad" => $precio,
                    "cantidad" => $cantidad,
                    "cantidad_s" => $cantidadSeccion,
                    "cantidad_sin_entregar" => $cantidadSeccion,
                    "sub_total_s" => $subTotalSecccionado,
                    "isv_s" => $isvSecccionado,
                    "total_s" => $totalSecccionado,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);

                array_push($this->arrayLogs, [
                    "origen" => $unidadesDisponibles->id,
                    "comprovante_entrega_id" => $idOrdenEntrega,
                    "cantidad" => $registroResta,
                    "unidad_medida_venta_id" => $idUnidadVenta,
                    "users_id" => Auth::user()->id,
                    "descripcion" => "Orden de Entrega",
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
}
