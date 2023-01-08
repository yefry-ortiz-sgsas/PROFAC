<?php

namespace App\Http\Livewire\NotaDebito;

use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;

class NotaDebito extends Component
{
    public function render()
    {
        return view('livewire.nota-debito.nota-debito');
    }

    public function listarFacturas(){

        try {

            $listaFacturas = DB::SELECT("
            select
            factura.id as id,
            @i := @i + 1 as contador,
            numero_factura,
            factura.cai as correlativo,
            A.cai as cai,
            fecha_emision,
            cliente.nombre,
            tipo_pago_venta.descripcion,
            fecha_vencimiento,
            FORMAT(sub_total,2) as sub_total,
            FORMAT(isv,2) as isv,
            FORMAT(total,2) as total,
            factura.credito,
            users.name as creado_por,
            (select if(sum(monto) is null,0,sum(monto)) from pago_venta where estado_venta_id = 1   and factura_id = factura.id ) as monto_pagado,
            factura.estado_venta_id

            from factura
            inner join cliente
            on factura.cliente_id = cliente.id
            inner join tipo_pago_venta
            on factura.tipo_pago_id = tipo_pago_venta.id
            inner join users
            on factura.vendedor = users.id
            inner join cai A
            on factura.cai_id= A.id
            inner join pago_venta on (pago_venta.factura_id = factura.id)
            cross join (select @i := 0) r
            where ( YEAR(factura.created_at) >= (YEAR(NOW())-2) )and factura.estado_factura_id=1 and factura.estado_venta_id<>2 and pago_venta.tipo_pago_id = 3
            order by factura.created_at desc
            ");






            return Datatables::of($listaFacturas)
            ->addColumn('opciones', function ($listaFacturas) {


                    return

                    '<div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                            más</button>
                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                            <li>
                                <a class="dropdown-item" href="/detalle/venta/'.$listaFacturas->id.'" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Detalle de venta </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="/venta/cobro/'.$listaFacturas->id.'"> <i class="fa-solid fa-cash-register text-success"></i> Pagos </a>
                            </li>

                            <li>
                            <a class="dropdown-item" target="_blank"  href="/factura/cooporativo/'.$listaFacturas->id.'"> <i class="fa-solid fa-print text-info"></i> Imprimir Factura </a>
                            </li>

                            <li>
                            <a class="dropdown-item"  onclick="anularVentaConfirmar('.$listaFacturas->id.')" > <i class="fa-solid fa-ban text-danger"></i> Anular Factura </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="/crear/vale/'.$listaFacturas->id.'" > <i class="fa-solid fa-calendar-days text-success"></i> Agendar Entrega </a>
                            </li>


                        </ul>
                    </div>';

            })
            ->addColumn('estado_cobro', function ($listaFacturas) {


                if( round($listaFacturas->monto_pagado,2) >= str_replace(",","",$listaFacturas->total) ){

                    return
                    '

                    <p class="text-center" ><span class="badge badge-primary p-2" style="font-size:0.75rem">Completo</span></p>
                    ';

                }else{
                    return
                    '
                    <p class="text-center"><span class="badge badge-danger p-2" style="font-size:0.75rem">Pendiente</span></p>
                    ';
                }

           })
            ->rawColumns(['opciones','estado_cobro'])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar las compras.',
                'errorTh' => $e,
            ], 402);

        }

    }
}
