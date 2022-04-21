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


    public function guardarCompra(){
        
        try {

            


        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al realizar la compra.',
                'error' => $e,
            ], 402);
        }

    }


}
