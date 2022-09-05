<?php

namespace App\Http\Livewire\Cardex;

use Livewire\Component;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use DataTables;

class Cardex extends Component
{
    public function render()
    {
        return view('livewire.cardex.cardex');
    }


    public function listarBodegas(Request $request){
        try {

            $bodegas = DB::SELECT("select id, concat(id,' - ',nombre) as text  from bodega where estado_id = 1 and (id LIKE '%".$request->search."%' or nombre Like '%".$request->search."%') limit 15");

            return response()->json([
                "results" => $bodegas,
            ], 200);

        } catch (QueryException $e) {
            DB::rollback();

            return response()->json([
                'message' => 'Ha ocurrido un error al listar las bodegas.',
                'errorTh' => $e,
            ], 402);
        }
    }

    public function listarProductos(Request $request){
        try {

            $productos = DB::SELECT("
                SELECT producto.id as id, concat(producto.id,' - ',producto.nombre) as text FROM producto
                INNER JOIN recibido_bodega on (producto.id = recibido_bodega.producto_id)
                INNER JOIN seccion on (seccion.id = recibido_bodega.seccion_id)
                INNER JOIN segmento on (segmento.id = seccion.segmento_id)
                INNER JOIN bodega on (segmento.bodega_id = bodega.id)
                WHERE
                estado_producto_id = 1
                and  producto.nombre like  '%".$request->search."%'
                and bodega.id = ".$request->idBodega);

            return response()->json([
                "results" => $productos,
            ], 200);

        } catch (QueryException $e) {
            DB::rollback();

            return response()->json([
                'message' => 'Ha ocurrido un error al listar las bodegas.',
                'errorTh' => $e,
            ], 402);
        }
    }

    public function listarCardex($idBodega, $idProducto){
        //dd($idBodega, $idProducto);
        try {

            $listaCardex = DB::SELECT("

            select
            log_translado.created_at as 'fechaIngreso',
            producto.nombre as 'producto',
            producto.id as 'codigoProducto',
            log_translado.factura_id as 'factura',
            log_translado.ajuste_id as 'ajuste' ,
            log_translado.descripcion as 'descripcion',
            concat (bodega.nombre,' ',seccion2.descripcion) as origen, 
              concat(                 
              (select
              bodega.nombre
              from seccion 
              inner join segmento 
              on segmento.id = seccion.segmento_id
              inner join bodega 
              ON bodega.id = segmento.bodega_id
              where seccion.id = log_translado.destino
              ),
              ' '
              ,
              (
              select
              seccion.descripcion
              from seccion 
              inner join segmento 
              on segmento.id = seccion.segmento_id
              inner join bodega 
              ON bodega.id = segmento.bodega_id
              where seccion.id = log_translado.destino
              )
              ) as destino,
              
            log_translado.cantidad as 'cantidad',
            users.name as  'usuario'
        from log_translado
            inner join recibido_bodega on (recibido_bodega.id = log_translado.origen)
    
            inner join producto on (recibido_bodega.producto_id = producto.id)
            inner join seccion as seccion2 on (seccion2.id = recibido_bodega.seccion_id)
            inner join segmento on (segmento.id = seccion2.segmento_id)
            inner join bodega on (bodega.id = segmento.bodega_id)
            inner join users on (users.id = log_translado.users_id)
    where bodega.id = ".$idBodega." and producto.id =".$idProducto
            );

            return Datatables::of($listaCardex)
            ->addColumn('doc_factura', function($elemento){
                return '<a target="_blank" href="/detalle/venta/'.$elemento->factura.'">'.$elemento->factura.'</a>';
            })
            ->addColumn('doc_ajuste', function($elemento){
                return '<a target="_blank" href="/ajustes/imprimir/ajuste/'.$elemento->ajuste.'">'.$elemento->ajuste.'</a>';
            })
            ->rawColumns(['doc_factura','doc_ajuste'])
            ->make(true);

        } catch (QueryException $e) {

            return response()->json([
                "message" => "Ha ocurrido un error al listar el cardex solicitado.",
                "error" => $e
            ]);
        }

    }
}
