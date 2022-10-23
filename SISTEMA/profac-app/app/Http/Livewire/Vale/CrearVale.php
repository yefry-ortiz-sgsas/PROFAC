<?php

namespace App\Http\Livewire\Vale;

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

use App\Models\ModelFactura;
use App\Models\ModelCAI;
use App\Models\ModelRecibirBodega;
use App\Models\ModelVentaProducto;
use App\Models\ModelLogTranslados;
use App\Models\ModelParametro;
use App\Models\ModelLista;
use App\Models\ModelCliente;
use App\Models\logCredito;
use App\Models\User;

use App\Models\ModelVale;
use App\Models\ModelValeHasProducto;
use Throwable;

class CrearVale extends Component
{


    
    public $idFacturaVale;
    public $arrayProductos =[];

    public function mount($id)
    {
        $this->idFacturaVale = $id;
    }


    public function render()
    {

        $idFactura = $this->idFacturaVale;

        $detalleVenta = DB::table('factura')

            ->join('tipo_pago_venta', 'factura.tipo_pago_id', '=', 'tipo_pago_venta.id')
            ->join('cliente', 'factura.cliente_id', '=', 'cliente.id')
            ->join('users', 'factura.vendedor', '=', 'users.id')
            ->join('estado_venta', 'factura.estado_venta_id', '=', 'estado_venta.id')

            ->select('factura.*', 'tipo_pago_venta.descripcion as tipo_pago', 'cliente.*', 'users.name', 'estado_venta.descripcion as estado_venta')

            ->where('factura.id', '=', $idFactura)

            ->get();

        $detalleVenta = $detalleVenta[0];



        return view('livewire.vale.crear-vale', compact('idFactura', 'detalleVenta'));
    }

    public function listarProductos(Request $request){
       try {
       
        $listaProductos = DB::SELECT("
        select
        B.id,
        concat('cod ',B.id ,' - ',B.nombre) as text
        from venta_has_producto A
        inner join producto B
        on A.producto_id = B.id 
        where A.factura_id = ".$request->idFactura."
        group by A.producto_id
        limit 15
        ");


        return response()->json([
            "results" => $listaProductos
        ], 200);


       } catch (QueryException $e) {
       return response()->json([
        'icon' => '',
        'text' => '',
        'title' => '',
        'message' => 'Ha ocurrido un error', 
        'error' => $e,
       ],402);
       }
    }

    public function datosProducto(Request $request){
       try {



        $producto = DB::SELECTONE("
        select 
        B.id,
        concat(B.id,'-',B.nombre) as nombre,
        B.isv,
        FORMAT(ultimo_costo_compra,2) as ultimo_costo_compra,
        FORMAT(precio_base,2) as precio_base
        from venta_has_producto A
        inner join producto B
        on A.producto_id = B.id
        where A.factura_id = ".$request->idFactura." and A.producto_id =".$request->idProducto
        );

        
        $unidades = DB::SELECT(
        "
        select
            C.unidad_venta as id,
            CONCAT(D.nombre,'-',C.unidad_venta) as nombre,
            C.id as idUnidadVenta
        from venta_has_producto A
            inner join producto B
            on A.producto_id = B.id
            inner join unidad_medida_venta C
            on C.producto_id = B.id
            inner join unidad_medida D
            on C.unidad_medida_id = D.id
        where  C.id = A.unidad_medida_venta_id and A.factura_id = ".$request->idFactura." and A.producto_id = ".$request->idProducto
        );

        $bodega = DB::SELECTONE("
        select 
            B.id as idSeccion,
            concat(D.nombre,'-',B.descripcion ) as bodega,        
            D.id as idBodega,
            A.lote as idLote
         
        from venta_has_producto A
            inner join seccion B
            on A.seccion_id = B.id
            inner join segmento C
            on B.segmento_id = C.id
            inner join bodega D
            on D.id = C.bodega_id
        where A.factura_id = ".$request->idFactura." and A.producto_id = ".$request->idProducto
    );


        return response()->json([
            "producto" => $producto,
            "unidades" => $unidades,
            "bodega" => $bodega
        ], 200);

     
       } catch (QueryException $e) {
       return response()->json([
        'icon' => 'error',
        'text' => 'Ha ocurrido un error',
        'title' => 'Error!',
        'message' => 'Ha ocurrido un error', 
        'error' => $e,
       ],402);
       }
    }



    public function crearVale(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'fecha_vencimiento' => 'required',
            'subTotalGeneral' => 'required',
            'isvGeneral' => 'required',
            'totalGeneral' => 'required',
            'arregloIdInputs' => 'required',
            'numeroInputs' => 'required',
          
            'nombre_cliente_ventas' => 'required',
            'tipoPagoVenta' => 'required',
        
            'vendedor' => 'required'



        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon' => 'error',
                'title' => 'error',
                'text' => 'Por favor, verificar que todos los campos esten completados.',
                'mensaje' => 'Ha ocurrido un error al crear la compra.',
                'errors' => $validator->errors()
            ], 401);
        }
        //

      //  dd($request->all());
        $arrayInputs = [];
        $arrayInputs = $request->arregloIdInputs;
        
     


        try {
            DB::beginTransaction();

            $idVale = DB::selectOne("  select id  from vale order by id desc");           
            $anio = DB::SELECTONE("select year(now()) as anio");
            $numero_vale="";
            if(empty($idVale->id)){
                $numero_vale = '1'.'-'.$anio->anio;
            }else{
                $numero_vale = ($idVale->id+1).'-'.$anio->anio;
            }

                
            $vale = new ModelVale;    
            $vale->numero_vale = $numero_vale;
            $vale->sub_total = $request->subTotalGeneral;
            $vale->isv = $request->isvGeneral;
            $vale->total = $request->totalGeneral;
            $vale->factura_id = $request->idFactura;
            $vale->users_id = Auth::user()->id;
            $vale->notas = $request->comentario;
            $vale->estado_id = 1;
            $vale->save();

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
                $KeyIdLote ='idLote'.$arrayInputs[$i];

              
                $idSeccion = $request->$keyIdSeccion;
                $idProducto = $request->$keyIdProducto;
                $idUnidadVenta = $request->$keyIdUnidadVenta;
             
                $idLote = $request-> $KeyIdLote;

                $precio = $request->$keyPrecio;
                $cantidad = $request->$keyCantidad;
                $subTotal = $request->$keySubTotal;
                $isv = $request->$keyIsv;
                $total = $request->$keyTotal;

                $restaInventario = $request->$keyRestaInventario;
                // $ivsProducto = $request->$keyISV;
                // $unidad = $request->$keyunidad;

                $this->calcularUnidadesPendientes($vale->id,$idProducto,$idLote,$idSeccion,$idUnidadVenta,
                $precio,$subTotal,$isv,$total,$cantidad,$restaInventario);
        
               
               
            };
        
            ModelValeHasProducto::insert($this->arrayProductos);
            DB::commit();
            return response()->json([
                'icon' => 'success',
                'text' => 'Vale de entrega creado con exito.',
                'title' => 'Exito!',
            ], 200);
        } catch (QueryException $e) {
            DB::rollback();

           return response()->json([
                'icon' => 'error',
                'text' => 'Ha ocurrido un error al crear el vale',
                'title' => 'Error!',
                'message' => 'Ha ocurrido un error',
                'error' => $e,
            ], 402);
        }
    }

    public function calcularUnidadesPendientes($idVale,$idProducto,$idLote,$idSeccion,$idUnidadVenta,
    $precio,$subTotal,$isv,$total,$cantidad,$restaInventario){

        


        array_push($arrayProductos,[
            'vale_id'=>$idVale,
            'producto_id'=> $idProducto,
            'lote_id'=>$idLote,
            'seccion_id'=>$idSeccion,
            'unidad_medida_venta_id'=>$idUnidadVenta,              
            'precio_unidad'=>$precio,
            'sub_total'=>$subTotal,
            'isv'=>$isv,
            'total'=>$total,
            'cantidad_pendiente_entrega'=>$cantidad,
            'resta_inventario_total'=> $restaInventario,
            'cantidad_s'=>$restaInventario,// realizar algoritmo para restar a lotes
            'created_at'=>NOW(),
            'updated_at'=>NOW()
           
   
           ]);


    }
}
