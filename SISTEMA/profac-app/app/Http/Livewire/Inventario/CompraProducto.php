<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;




use App\Models\Modelproveedores;
use App\Models\ModelProducto;
use App\Models\ModelTipoPago;
use App\Models\ModelCompra;
use App\Models\ModelCompraProducto;


class CompraProducto extends Component
{
    public function render()

    {
        

        $ordenNumero = DB::selectOne("select count(id) as 'numero' from compra");

        return view('livewire.inventario.compra-producto',compact( "ordenNumero"));
    }

    public function listarProveedores(Request $request){

        try {

            $proveedores = DB::SELECT("select id, concat(id,' - ',nombre) as text  from proveedores where id LIKE '%".$request->search."%' or nombre Like '%".$request->search."%' limit 15");
            
            return response()->json([
                "results" => $proveedores,
            ], 200);
        } catch (QueryException $e) {
            DB::rollback();

            return response()->json([
                'message' => 'Ha ocurrido un error al listar los proveedores.',
                'errorTh' => $e,
            ], 402);
        }
    }

    public function listarFormasPago(){
        try {

            $tipos = ModelTipoPago::all();

            return response()->json([
                "tipos" =>  $tipos,

            ],200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar los tipos de pago.',
                'errorTh' => $e,
            ], 402);
        }
    }


    public function listarProductos(Request $request){

        try {

            $productos = DB::SELECT("select id, concat(id, ' - ', nombre) as 'text' from producto proveedores where id LIKE '%".$request->search."%' or nombre Like '%".$request->search."%' limit 15");
            
            return response()->json([
                "results" => $productos,
            ], 200);
        } catch (QueryException $e) {
          

            return response()->json([
                'message' => 'Ha ocurrido un error al listar los productos.',
                'errorTh' => $e,
            ], 402);
        }
    }

    public function obtenerImagenes(Request $request){
        try {
        $imagenes = DB::SELECT("
        
        select
            @i := @i + 1 as contador,
            id,
            url_img
        from 
            img_producto
            cross join (select @i := 0) r
            where producto_id = ".$request['id']."

        ");

        return response()->json([
            "imagenes" => $imagenes,
        ], 200);

           
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar las imagenes.',
                'errorTh' => $e,
            ], 402);

          
        }
    }


    public function obtenerDatosProducto(Request $request){

        try {

         
            $producto = DB::SELECT("
            select
            id,
            concat(nombre,' - ',codigo_barra) as nombre,
            isv

            from producto where id = ".$request['id']."
            ");


            return response()->json([
                "producto" => $producto[0],
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al obtener los datos del producto.',
                'error' => $e,
            ], 402);
        }

    }

    public function comprobarRetencion(Request $request){        
        try {

            $retencion = DB::SELECTONE("
            select
                proveedores_id
            from 
            retenciones_has_proveedores
            where proveedores_id = ".$request['idProveedor']." and retenciones_id = 2
            ");

           // dd($retencion);

            
            if(empty($retencion)){
                return response()->json([
                    'title' => '*No* se registra retencion del 1% para este proveedor.',
                    'text' => '¿Desea aplicar retención del 1% a esta compra?',
                    'retencion_id' => 1,
                ], 200);

            }else{
                return response()->json([
                    'title' => '*Se* registra retencion del 1% para este proveedor. ',
                    'text' => '¿Desea aplicar retención del 1% a esta compra?',
                    'retencion_id' => 2,
                ], 200);

            }       

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al realizar la compra.',
                'error' => $e,
            ], 402);
        }

    }


    public function guardarCompra(Request $request){

        //dd($request->all());
       $validator = Validator::make($request->all(), [
            'numero_emision' => 'required',
            'numero_factura' => 'required',
            'tipoPagoCompra' => 'required', 
            'fecha_vencimiento' => 'required',
            'fecha_emision' => 'required',
            'fecha_entrega' => 'required',
            'tipoPagoCompra' => 'required', 
            'subTotalGeneral' => 'required',
            'isvGeneral' => 'required',
            'totalGeneral' => 'required', 
            'retencion' => 'required',
            'arregloIdInputs' => 'required',
            'numeroInputs' => 'required',
            'seleccionarProveedorId' => 'required',
        

            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al crear la compra.',
                'errors' => $validator->errors()
            ], 406);
        }

        try {

            DB::beginTransaction();
            $ordenNumero = DB::selectOne("select count(id) as 'numero' from compra");

            $guardarCompra = new ModelCompra;
            $guardarCompra->fecha_vencimiento = $request['fecha_vencimiento'];
            $guardarCompra->fecha_emision = $request->fecha_emision;
            $guardarCompra->fecha_recepcion = $request->fecha_entrega;
            $guardarCompra->isv_compra = $request->isvGeneral;
            $guardarCompra->sub_total =$request->subTotalGeneral ;
            $guardarCompra->total =$request->totalGeneral;
            $guardarCompra->debito =$request->totalGeneral;
            $guardarCompra->proveedores_id =$request->seleccionarProveedorId ;
            $guardarCompra->users_id = Auth::user()->id ;
            $guardarCompra->tipo_compra_id = $request->tipoPagoCompra;
            $guardarCompra->numero_orden = $ordenNumero->numero+1;
            $guardarCompra->monto_retencion = $request->retencion;
            $guardarCompra->retenciones_id = 2;
            $guardarCompra->numero_factura = $request->numero_factura;
            $guardarCompra->save();

            $idCompra = $guardarCompra->id;

            //dd( $guardarCompra);

            $arrayInputs=[];
            $arrayInputs = $request->arregloIdInputs;


            for ($i=0; $i < count($arrayInputs) ; $i++) { 

                $idProducto = 'idProducto'.$arrayInputs[$i];
                $precio='precio'.$arrayInputs[$i];
                $cantidad='cantidad'.$arrayInputs[$i];
                $vencimiento='vencimiento'.$arrayInputs[$i];
                $subTotal='subTotal'.$arrayInputs[$i];
                $isvProducto='isvProducto'.$arrayInputs[$i];
                $total='total'.$arrayInputs[$i];

                $productoCompra = new ModelCompraProducto;
                $productoCompra->compra_id = $idCompra;
                $productoCompra->producto_id = $request->$idProducto;
                $productoCompra->precio_unidad = $request->$precio;
                $productoCompra->isv = $request->$isvProducto;
                $productoCompra->sub_total_producto=$request->$subTotal;
                $productoCompra->precio_total = $request->$total;
                $productoCompra->cantidad_ingresada = $request->$cantidad;
                $productoCompra->cantidad_disponible = $request->$cantidad;
                $productoCompra->fecha_expiracion = $request->$vencimiento;
                $productoCompra->estado_recibido = 3;//pediente de recibir 
                $productoCompra->save();

               
            }

            DB::commit();

            return response()->json([
                'message' => 'Creado con exito.',
                
            ], 200);  

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al realizar la compra.',
                'error' => $e,
            ], 402);
        }

    }


}
