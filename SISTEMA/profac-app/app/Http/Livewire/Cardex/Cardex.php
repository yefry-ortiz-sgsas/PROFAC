<?php

namespace App\Http\Livewire\Cardex;

use Livewire\Component;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

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

    public function listarProductos($id){
        try {

            $productos = DB::SELECT("
                SELECT producto.id as id, concat(producto.id,' - ',producto.nombre) as text FROM producto
                INNER JOIN recibido_bodega on (producto.id = recibido_bodega.producto_id)
                INNER JOIN seccion on (seccion.id = recibido_bodega.seccion_id)
                INNER JOIN segmento on (segmento.id = seccion.segmento_id)
                INNER JOIN bodega on (segmento.bodega_id = bodega.id)
                WHERE
                estado_producto_id = 1 AND
                bodega.id =".$id);

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

    public function listarCardex(){

        try {

            $listaCardex = DB::SELECT("

            SELECT
            @i := @i + 1 as contador,
            users.id as id,
            name as nombre,
            telefono,
            email,
            identidad,
            fecha_nacimiento,
            rol.nombre as tipo_usuario,
            users.created_at as fecha_registro

            FROM users inner join rol
            on users.rol_id = rol.id
            cross join (select @i := 0) r


            ");

            return Datatables::of($listaUsuarios)


            ->make(true);

        } catch (QueryException $e) {

            return response()->json([
                "message" => "Ha ocurrido un error al listar los usuarios.",
                "error" => $e
            ]);
        }

    }
}
