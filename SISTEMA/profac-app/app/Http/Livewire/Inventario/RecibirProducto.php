<?php

namespace App\Http\Livewire\Inventario;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\ModelPagoCompra;
use App\Models\ModelCompra;
use App\Models\modelBodega; 
use App\Models\ModelCompraProducto; 
use Auth;
use DataTables;

use Livewire\Component;

class RecibirProducto extends Component
{
    public $idCompra;
    public function mount($id)
    {

        $this->idCompra = $id;
    }

    public function render()
    {
        $idCompra = $this->idCompra;

        return view('livewire.inventario.recibir-producto', compact('idCompra'));
    }

    public function listarProductos($id)
    {
        try {

            $listaCompra = DB::SELECT("
        select
        
        A.compra_id,
        A.producto_id as 'producto_id',
        producto.nombre as nombre,            
        A.precio_unidad,
        A.cantidad_ingresada,
        A.sub_total_producto,
        A.isv,
        A.precio_total,
        if(A.fecha_expiracion is null, 'No definido',A.fecha_expiracion) as fecha_expiracion,
        estado.descripcion as 'estado_recibido',
        if(A.fecha_recibido is null ,'No recibido',A.fecha_recibido) as fecha_recibido,
        if((select name from users where id= A.recibido_por) is null, 'No recibido',(select name from users where id= A.recibido_por) ) as 'name'           
    from 
        compra_has_producto A
        inner join producto
        on producto.id = A.producto_id    
        inner join estado
        on A.estado_recibido = estado.id
        where A.compra_id =  " . $id . "
        ");

            return Datatables::of($listaCompra)
                ->addColumn('opciones', function ($listaCompra) {

                    return
                        '
            <div class="text-center">
                <button class="btn btn-warning " onclick="mostratModal(' . $listaCompra->compra_id . ',' . $listaCompra->producto_id . ')"><i class="fa-solid fa-dolly"></i></button>
            </div>

        ';
                })

                ->rawColumns(['opciones'])
                ->make(true);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ]);
        }
    }

    public function bodegasLista()
    {
        

        try {

            $listaBodegasRecibir = DB::SELECT("
            select 
            id,
                nombre 
            From 
                bodega
            ");

            //$listaBodegasRecibir = modelBodega::all();

            return response()->json([
                "listaBodegas" => $listaBodegasRecibir
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ], 402);
        }
    }

    public function listarSegmentos(Request $request)
    {
        try {

            $listaSegmentos = DB::select("
         select id, descripcion from segmento where bodega_id = " . $request->idBodega);



            return response()->json([
                "listaSegmentos" => $listaSegmentos
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ]);
        }
    }

    public function listarSecciones(Request $request)
    {
        try {

            $listaSecciones = DB::select("
         select id, descripcion from seccion where segmento_id = " . $request->idSegmento);

            return response()->json([
                "listaSecciones" => $listaSecciones
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ]);
        }
    }

    public function guardarEnBodega(Request $request){
        try {

            

            DB::table('compra_has_producto')
            ->where('compra_id','=', $request->idCompra)
            ->where('producto_id','=', $request->idProducto)
            ->update([
                'seccion_id' => $request->idSeccion,
                'estado_recibido' => 4,
                'recibido_por' => Auth::user()->id,
                'fecha_recibido' => now(),
        ]);
           

            return response()->json([
                "listaSecciones" => "guardado con exito"
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => $e
            ]);
        }

    }
}
