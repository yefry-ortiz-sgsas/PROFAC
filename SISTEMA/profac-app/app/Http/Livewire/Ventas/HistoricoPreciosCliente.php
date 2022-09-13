<?php

namespace App\Http\Livewire\Ventas;

use Livewire\Component;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use DataTables;
use Throwable;

class HistoricoPreciosCliente extends Component
{
    public function render()
    {
        return view('livewire.ventas.historico-precios-cliente');
    }

    public function listarClientes(Request $request){
        try {
 
         //$clientes = DB::SELECT("select id, nombre as text from cliente where estado_cliente_id = 1");//Clientes Activos
         $clientes = DB::SELECT("select id, nombre as text from cliente where (id LIKE '%".$request->search."%' or nombre Like '%".$request->search."%')");//Todos los Clientes

        return response()->json([
            'results'=>$clientes,
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
 
         $productos = DB::SELECT("select id, nombre as text from producto where (id LIKE '%".$request->search."%' or nombre Like '%".$request->search."%')");//Todos los productos

        return response()->json([
            'results'=>$productos,
        ],200);
       
        } catch (QueryException $e) {
        return response()->json([
         'message' => 'Ha ocurrido un error', 
         'error' => $e
        ],402);
        }
    }

    public function listarHistoricoPrecios($cliente, $producto){
        try{

            $historicos = DB::SELECT("select
            A.numero_factura,
            A.cai,
            A.fecha_emision,
            A.nombre_cliente,
            C.nombre as producto,
            C.descripcion,
            E.nombre as unidad_medida,
            B.cantidad,
            B.precio_unidad,
            B.sub_total,
            B.isv,
            B.total
            from factura A
            inner join venta_has_producto B
            on A.id = B.factura_id
            inner join producto C
            on B.producto_id = C.id
            inner join unidad_medida_venta D
            on B.unidad_medida_venta_id = D.id
            inner join unidad_medida E
            on D.unidad_medida_id = E.id
            where A.cliente_id = '". $cliente."' and B.producto_id = '". $producto."'");

        return Datatables::of($historicos)
                ->addColumn('opciones', function ($historico) {

                    return

                        '
                <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                    más</button>
                <ul class="dropdown-menu" x-placement="bottom-start"
                    style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                    
                    <li>
                    <a class="dropdown-item"   ><i class="fa-solid fa-xmark text-danger"></i> Desactivar </a>
                    </li>

                </ul>
            </div>
                ';
                })
            

                ->rawColumns(['opciones'])
                ->make(true);
        } catch (QueryException $e) {


            return response()->json([
                'message' => 'Ha ocurrido un error al listar las cuentas.',
                'errorTh' => $e,
            ], 402);
        }
    }


}
