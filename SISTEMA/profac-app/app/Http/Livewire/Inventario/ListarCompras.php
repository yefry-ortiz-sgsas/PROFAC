<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;
use DataTables;

class ListarCompras extends Component
{
    public function render()
    {
        return view('livewire.inventario.listar-compras');
    }

    public function listarCompras(){

        try {

            $listarCompras = DB::SELECT("
            select
                compra.id as id,
                numero_orden,
                numero_factura,
                fecha_emision,
                fecha_vencimiento,
                total,
                IF(monto_retencion = 0,'SIN RETENCION','CON RETENCION') as 'estado_retencion',
                proveedores.nombre,
                users.name as usuario,
                compra.created_at as fecha_registro
            from compra
            inner join users
            on compra.users_id = users.id
            inner join proveedores
            on compra.proveedores_id = proveedores.id
            order by compra.id DESC 
            ");

            return Datatables::of($listarCompras)
            ->addColumn('opciones', function ($listarCompras) {

                return

                '<div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                        más</button>
                    <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                        <li>
                            <a class="dropdown-item" href="/producto/compras/detalle/'.$listarCompras->id.'" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Detalle de compra </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="/producto/compra/pagos/'.$listarCompras->id.'"> <i class="fa-solid fa-cash-register text-success"></i> Pagos </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="/producto/compra/recibir/'.$listarCompras->id.'" > <i class="fa-solid fa-cart-arrow-down text-warning"></i> Recepción de producto </a>
                        </li>                        

                    </ul>
                </div>';
            })
            ->rawColumns(['opciones'])
            ->make(true);
           
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar las compras.',
                'errorTh' => $e,
            ], 402);
           
        }

    }
}
