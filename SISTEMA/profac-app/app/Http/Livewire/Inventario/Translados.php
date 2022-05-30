<?php

namespace App\Http\Livewire\Inventario;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use Auth;
use DataTables;
use Validator;
use Illuminate\Support\Facades\File;

use App\Models\modelBodega;
use App\Models\ModelRecibirBodega; 
use App\Models\ModelLogTranslados;

use Livewire\Component;

class Translados extends Component
{
    public function render()
    {
        return view('livewire.inventario.translados');
    }

    public function listarBodegas(){
       try {

        $listaBodegas = DB::SELECT("
            select id ,nombre as 'text' from bodega
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

    public function listarSecciones(Request $request){
       try {

        $listaSecciones = DB::SELECT("select
        seccion.id,
        seccion.descripcion
        from bodega
        inner join segmento
        on bodega.id = segmento.bodega_id
        inner join seccion
        on seccion.segmento_id = segmento.id
        where bodega.id = ".$request->idBodega);

       return response()->json([
           "listaSecciones" =>  $listaSecciones
       ]);
       } catch (QueryException $e) {
       return response()->json([
           'message' => 'Ha ocurrido un error', 
           'error' => $e
       ]);
       }
    }

 

    public function listarProductos(Request $request){
       try {

        $listaProductos = DB::select("
        select id, concat(id,' - ',nombre) as text from producto where nombre like '%".$request->search."%' or id like '%".$request->search."%' limit 15
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

    public function productoBodega($idBodega,$idProducto){
       try {
           //dd($idBodega,$idProducto);

        $listaProductos = DB::SELECT("
        select 
            A.id as 'idRecibido',
            B.id as 'idProducto',
            B.nombre,
            C.nombre as 'simbolo',
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
        where A.cantidad_disponible <> 0 and compra.estado_compra_id = 1 and bodega.id = ".$idBodega." and A.producto_id = ".$idProducto
        );

        return Datatables::of($listaProductos)
        ->addColumn('opciones', function ($producto) {

            return

            '<div class="text-center">
                <button class="btn btn-warning" onclick="modalTranslado('.$producto->idRecibido.')">
                    Transladar
                </button>
               
            </div>';
        })

        ->rawColumns(['opciones',])
        ->make(true);

       } catch (QueryException $e) {
       return response()->json([
           'message' => 'Ha ocurrido un error', 
           'error' => $e
       ]);
       }
    }

    public function ejectarTranslado(Request $request){
       try {
        $validator = Validator::make($request->all(), [
           
            'idRecibido' => 'required',
            'cantidad' => 'required'              

        ], [
            
            'idRecibido' => 'codigo de recibido es necesario.',
            'cantidad' => 'la cantidad de producto a transladar es requerida'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "text" => "Ha ocurrido un error al realizar el transpaso de producto, uno o mas campos faltantes.",
                "icon" => "error",
                "title"=>"Error!"
            ], 402);
        }

        
        $productoEnBodega = ModelRecibirBodega::find($request['idRecibido']);
      

        if($productoEnBodega->cantidad_disponible >= $request->cantidad ){
            

        DB::beginTransaction();

            $transladarBodega = new ModelRecibirBodega();
            $transladarBodega->compra_id = $productoEnBodega->compra_id;
            $transladarBodega->producto_id = $productoEnBodega->producto_id;
            $transladarBodega->seccion_id = $request->seccion;
            $transladarBodega->cantidad_compra_lote = $productoEnBodega->cantidad_compra_lote;
            $transladarBodega->cantidad_inicial_seccion = $request->cantidad;
            $transladarBodega->cantidad_disponible = $request->cantidad;
            $transladarBodega->fecha_recibido = now();
            $transladarBodega->fecha_expiracion = $productoEnBodega->fecha_expiracion;
            $transladarBodega->estado_recibido = 4;
            $transladarBodega->recibido_por = Auth::user()->id;
            $transladarBodega->save();

            $logTranslados = new ModelLogTranslados;
            $logTranslados->origen = $productoEnBodega->id ;
            $logTranslados->destino = $transladarBodega->id;
            $logTranslados->cantidad = $request->cantidad;
            $logTranslados->users_id= Auth::user()->id; 
            $logTranslados->descripcion="Translado de bodega";
            $logTranslados->save();


            $productoEnBodega->cantidad_disponible = $productoEnBodega->cantidad_disponible - $request->cantidad;
            $productoEnBodega->save();

            DB::commit();
            return response()->json([
                "text" => "El producto ha sido transladado de bodega con éxito.",
                "icon" => "success",
                "title"=>"Exito!"
            ], 200);

        }else{

            return response()->json([
                "text" => "La cantidad solicitada para translado de bodega, excede la cantidad disponible. No se puede transladar el producto.",
                "icon" => "warning",
                "title"=>"Advertencia!"
            ], 402);
            

        }        

       } catch (QueryException $e) {
        DB::rollback(); 
        return response()->json([
            "text" => "Ha ocurrido un error, al intentar transladar el producto",
            "icon" => "error",
            "title"=>"Error!",
            'error' => $e
        ], 402);
       }
    }
    
    public function productoGeneralBodega($idSeccion,$idProducto){
        try {
        //dd($idSeccion,$idProducto);
            $idBodega = DB::SELECTONE("
                select
                    bodega.id
                from seccion 
                    inner join segmento
                    on seccion.segmento_id = segmento.id
                    inner join bodega
                    on bodega.id = segmento.bodega_id
                    where seccion.id =".$idSeccion);
        
                    
 
         $listaProductos = DB::SELECT("
         select 
             A.id as 'idRecibido',
             B.id as 'idProducto',
             B.nombre,
             C.nombre as 'simbolo',
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
         where A.cantidad_disponible <> 0 and compra.estado_compra_id = 1 and bodega.id = ".$idBodega->id." and A.producto_id = ".$idProducto
         );
 
         return Datatables::of($listaProductos)
        
         ->make(true);
 
        } catch (QueryException $e) {
        return response()->json([
            'message' => 'Ha ocurrido un error', 
            'error' => $e
        ]);
        }
     }
}


