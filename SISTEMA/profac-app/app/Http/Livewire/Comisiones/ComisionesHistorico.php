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
                    (select meses.nombre from meses where id = (
                        select comision_techo.meses_id from comision_techo
                        where  comision_techo.vendedor_id = co.vendedor_id
                        and comision_techo.id = co.comision_techo_id
                                                                        )
                    ) as mes,
                    FORMAT(co.gananciaTotal,2) as gananciaFactura,
                    co.porcentaje,
                    FORMAT(co.monto_comison,2) as montoAsignado,
                    usA.name as userRegistro,
                    co.created_at as fechaRegistro
                FROM comision co
                    inner join users us on (us.id = co.vendedor_id)
                    inner join users usA on (usA.id = co.users_registro_id)
                where co.estado_id = 1;

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

            select
                codigoVendedor,
                vendedor,
                mes,
                facturasComisionadas,
                montotecho as montotecho,
                sum(gananciaTotal) as gananciatotalMes,
                sum(montoAsignado)  as montoAsignado from (
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
                            group by codigoVendedor, vendedor, mes, facturasComisionadas,montotecho

            ");
            return Datatables::of($listaComisiones)
            ->addColumn('estadoPago', function ($listaComisiones) {
                return

                '<span class="badge badge-primary">No pagado</span>';
            })
            ->addColumn('acciones', function ($listaComisiones) {
                return

                '<div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                            más</button>
                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                            <li>
                                <a class="dropdown-item"  > <i class="fa-solid fa-cash-register text-info"></i> Pago de comisión </a>
                            </li>

                        </ul>
                    </div>';
            })
            ->rawColumns(['estadoPago','acciones'])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar las comisones.',
                'errorTh' => $e,
            ], 402);

        }
    }
}
