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

        $datosCompra = DB::SELECTONE("
     select
        A.numero_factura,
        A.numero_orden,
        B.nombre
      from
      compra A
      inner join proveedores B
      on A.proveedores_id = B.id
      where A.id = ".$idCompra);



        return view('livewire.inventario.recibir-producto', compact('idCompra','datosCompra'));
    }

    public function listarProductos($id)
    {
        try {

            $listaCompra = DB::SELECT("

        select
            @i := @i + 1 as 'contador',      
            A.compra_id,            
            A.producto_id as 'producto_id',
            producto.nombre as nombre,            
            A.precio_unidad,
            A.cantidad_ingresada as cantidad_comprada,
            A.sub_total_producto,
            A.isv,
            A.precio_total,
            if(A.fecha_expiracion is null, 'No definido',A.fecha_expiracion) as fecha_expiracion,
            (select sum(cantidad_inicial_seccion) from recibido_bodega where producto_id = A.producto_id and compra_id = A.compra_id ) as 'cantidad_ingresada_bodega'
          
        from 
            compra_has_producto A
            inner join producto
            on producto.id = A.producto_id    
            cross join (select @i := 0) r
            where A.compra_id = ".$id."

 
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
                ->addColumn('estado_recibido', function ($listaCompra){
                    if($listaCompra->cantidad_comprada == $listaCompra->cantidad_ingresada_bodega){
                        return
                        '

                        <p class="text-center" ><span class="badge badge-primary p-2" style="font-size:0.95rem">Recibido</span></p>
                        ';

                    }else if($listaCompra->cantidad_ingresada_bodega < $listaCompra->cantidad_comprada  ){
                        return
                        '
                        <p class="text-center"><span class="badge badge-danger">Incompleto</span></p>
                        ';
                    }else if($listaCompra->cantidad_ingresada_bodega > $listaCompra->cantidad_comprada){
                        return
                        '
                        <p class="text-center"><span class="badge badge-warning">Excedente</span></p>
                        ';

                    }else if($listaCompra->cantidad_ingresada_bodega >= 0){
                        return
                        '
                        <p class="text-center"><span class="badge ">No recibido</span></p>
                        ';
                    }
                   
                })

                ->rawColumns(['opciones','estado_recibido'])
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
