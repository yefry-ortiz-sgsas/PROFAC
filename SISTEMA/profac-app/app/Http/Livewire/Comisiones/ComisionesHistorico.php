<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use App\Models\Comisiones\desglose;

use App\Models\Comisiones\comision;

class ComisionesHistorico extends Component
{
    public function render()
    {
        return view('livewire.comisiones.comisiones-historico');
    }

    public function listarHistorico(){

        //dd("llego al historico");
        try {
            $listaComisiones = DB::SELECT("

            SELECT
                co.comision_techo_id as codigoComision,
                co.factura_id as idFactura,
                co.vendedor_id,
                us.name as vendedor,
                co.gananciaTotal as gananciaFactura,
                co.porcentaje,
                co.monto_comison as montoAsignado,
                usA.name as userRegistro,
                co.created_at as fechaRegistro
            FROM comision co
                inner join users us on (us.id = co.vendedor_id)
                inner join users usA on (usA.id = co.users_registro_id)
            where estado_id = 1

            ");
            return Datatables::of($listaComisiones)
            ->addColumn('acciones', function ($listaComisiones) {
                    return

                    '<div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                            más</button>
                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                            <li>
                                <a class="dropdown-item" href="/desglose/factura/'.$listaComisiones->idFactura.'" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Ver Desglose </a>
                            </li>

                        </ul>
                    </div>';
            })
            ->rawColumns(['acciones'])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar las comisones.',
                'errorTh' => $e,
            ], 402);

        }

    }
}
