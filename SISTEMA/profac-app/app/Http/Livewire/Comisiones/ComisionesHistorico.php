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

    public function historicoMes(){



        try {
            $listaComisiones = DB::SELECT("

            select codigoVendedor, vendedor, mes, facturasComisionadas, CONCAT('L. ',FORMAT(sum(gananciaTotal),2)) as gananciatotalMes,CONCAT('L. ',FORMAT(sum(montoAsignado),2))  as montoAsignado from (
                select
                    co.id as codigoComision,
                    co.vendedor_id as codigoVendedor,
                    us.name as vendedor,
                    co.comision_techo_id as techo,
                    SUM(co.monto_comison) as montoAsignado,
                    co.gananciaTotal as gananciaTotal,
                    (
                        select count(comision.factura_id) from comision
                        inner join comision_techo on (comision_techo.id = comision.comision_techo_id)
                        where comision_techo.meses_id = m.id
                        and comision_techo.vendedor_id = co.vendedor_id
                    ) as facturasComisionadas,
                    m.nombre as mes,
                    ct.monto_techo as montotecho
                from comision co
                inner join users us on (us.id = co.vendedor_id)
                inner join comision_techo ct on (ct.id = co.comision_techo_id)
                inner join meses m on (m.id = ct.meses_id)
                where co.estado_id = 1 and ct.estado_id = 1
                group by co.id, us.name, co.comision_techo_id, co.monto_comison,facturasComisionadas, m.nombre, ct.monto_techo
            ) as comisiones
            group by codigoVendedor, vendedor, mes, facturasComisionadas

            ");
            return Datatables::of($listaComisiones)
            ->rawColumns([])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar las comisones.',
                'errorTh' => $e,
            ], 402);

        }
    }
}
