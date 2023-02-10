<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\ModelAjuste;
use App\Models\ModelTipoAjuste;
use App\Models\ModelLogTranslados;
use App\Models\ModelRecibirBodega;
use App\Models\ModelAjusteProducto;


class AjusteIngresoProducto extends Component
{
    public function render()
    {
        return view('livewire.inventario.ajuste-ingreso-producto');
    }

    public function obtenerProducto(Request $request){
        try {


            $productos = DB::SELECT("select id, concat(id,' - ',nombre) as text   from producto where nombre like '%".$request->search."%' or id like '%".$request->search."%' or codigo_barra like '%".$request->search."%' limit 15");

 
        return response()->json([
            "results" => $productos 
        ]);
        } catch (QueryException $e) {
        return response()->json([
            'message' => 'Ha ocurrido un error', 
            'error' => $e
        ]);
        }
    }

    public function datosProducto(Request $request){
        try {

         $producto = DB::SELECTONE("select id, nombre, precio_base from producto where id=".$request->id);
 
         $datosBodega = DB::SELECTONE("
         select
         UPPER(D.nombre) as bodega,
         UPPER(B.descripcion) as seccion         
         from  seccion B        
         inner join segmento C
         on C.id = B.segmento_id
         inner join bodega D
         on D.id = C.bodega_id
         where B.id = ".$request->idSeccion);
 
         $unidadesMedida = DB::SELECT("
         select
         B.id,
         B.unidad_venta,
         B.unidad_venta_defecto,
         CONCAT(C.nombre,'-',B.unidad_venta) as nombre
         from producto A
         inner join unidad_medida_venta B
         on A.id = B.producto_id
         inner join unidad_medida C
         on B.unidad_medida_id = C.id
         where A.id = ".$request->id);
 
        return response()->json([
         'unidadesMedida'=>$unidadesMedida,
         'producto'=>$producto,
         'datosBodega' => $datosBodega
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
}
