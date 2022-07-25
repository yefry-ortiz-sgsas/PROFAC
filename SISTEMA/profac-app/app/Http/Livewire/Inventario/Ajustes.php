<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use Auth;
use DataTables;
use Validator;
use Illuminate\Support\Facades\File;

use App\Models\ModelAjuste;
use App\Models\ModelTipoAjuste;
class Ajustes extends Component
{
    public function render()
    {
        return view('livewire.inventario.ajustes');
    }

    public function listarBodegas(Request $request){
        try {
 
         $listaBodegas = DB::SELECT("
             select id ,nombre as 'text' from bodega  where nombre like '%".$request->search."%' or id like '%".$request->search."%' limit 15
         ");

         
 
 
 
        return response()->json([
            "results" => $listaBodegas
 
        ],200);
        } catch (QueryException $e) {
        return response()->json([
            'message' => 'Ha ocurrido un error', 
            'error' => $e
        ],402);
        }
     }

     public function listarProductos(Request $request){
        try {

            //dd($request->all());
 
         $listaProductos = DB::select("
         select 
         B.id,
         CONCAT(B.id,' - ',B.nombre) as text            
         from recibido_bodega A
         inner join producto B
         on A.producto_id = B.id
         inner join seccion
         on A.seccion_id = seccion.id
         inner join segmento
         on seccion.segmento_id = segmento.id
         inner join bodega
         on segmento.bodega_id = bodega.id
         where bodega.id=".$request->bodegaId." and (B.nombre like '%".$request->search."%' or B.id like '%".$request->search."%') limit 15
         ");
 
        return response()->json([
            "results" => $listaProductos
        ]);
        } catch (QueryException $e) {
        return response()->json([
            'message' => 'Ha ocurrido un error', 
            'error' => $e
        ]);
        }
     }

     public function obtenerTiposAjuste(){

       
        $tiposAjuste = DB::select("select id, nombre as text from tipo_ajuste order by nombre asc");
        $usuarios = DB::SELECT("select id, name from users order by name asc");
        
        return response()->json([
            "results" => $tiposAjuste,
            "usuarios"=>$usuarios
        ]);
     }

     public function datosProducto(Request $request){
       try {

        $producto = DB::SELECTONE("select id, nombre, precio_base from producto where id=".$request->id);

       return response()->json([

        'producto'=>$producto,
       ],200);
       } catch (QueryException $e) {
       return response()->json([
        'icon' => 'error',
        'text' => 'Ha ocurrido un error al obtener los datos de producto',
        'title' => 'Error!',
        'message' => 'Ha ocurrido un error', 
        'error' => $e,
       ],402);
       }
     }

     public function listarProducto(Request $request){
       try {

        $listaProductos = DB::SELECT("
    
        select 
            A.id as 'idRecibido',
            B.id as 'idProducto',
            B.nombre,            
            C.nombre as 'simbolo',
            compra.numero_factura,
            compra.id as cod_compra,
            A.cantidad_disponible,
            bodega.nombre as bodega,
            seccion.id as 'idSeccion',
            seccion.descripcion,
            A.created_at
        from recibido_bodega A
            inner join producto B
            on A.producto_id = B.id
            inner join seccion
            on A.seccion_id = seccion.id
            inner join segmento
            on seccion.segmento_id = segmento.id
            inner join bodega
            on segmento.bodega_id = bodega.id
            inner join unidad_medida C
            on B.unidad_medida_compra_id = C.id
            inner join compra
            on A.compra_id = compra.id
            where A.cantidad_disponible <> 0 and compra.estado_compra_id = 1 and bodega.id = ".$request->idBodega." and A.producto_id = ".$request->idProducto
        );

        return Datatables::of($listaProductos)
        ->addColumn('opciones', function ($producto) {

            return

            '<div class="text-center">
                <button class="btn btn-warning" onclick="datosProducto('.$producto->idProducto.','.$producto->idRecibido.','.$producto->cantidad_disponible.')">
                    Realizar Ajuste
                </button>
               
            </div>';
        })

        ->rawColumns(['opciones',])
        ->make(true);

     

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
}
