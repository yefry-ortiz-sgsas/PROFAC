<?php

namespace App\Http\Livewire\Ventas;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;
use DataTables;

class ListadoFacturas extends Component
{
    public function render()
    {
        return view('livewire.ventas.listado-facturas');
    }

    public function listarFacturas(){

        try {

            $listaFacturas = DB::SELECT("
            select 
                factura.id as id,
                @i := @i + 1 as contador,
                numero_factura,
                cai,
                fecha_emision,
                cliente.nombre,
                tipo_pago_venta.descripcion,
                fecha_vencimiento,
                isv,
                total,
                factura.credito,
                concat( users.name,' ',factura.created_at) as creado_por,
                (select if(sum(monto) is null,0,sum(monto)) from pago_venta where estado_venta_id = 1   and factura_id = factura.id ) as monto_pagado
            
            from factura
                inner join cliente
                on factura.cliente_id = cliente.id
                inner join tipo_pago_venta
                on factura.tipo_pago_id = tipo_pago_venta.id
                inner join users
                on cliente.users_id = users.id
                cross join (select @i := 0) r
            where YEAR(factura.created_at) >= (YEAR(NOW())-2)
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
                            <a class="dropdown-item" href="/producto/compra/recibir/'.$listaFacturas->id.'" > <i class="fa-solid fa-cart-arrow-down text-warning"></i> Recepción de producto </a>
                        </li> 
                        <li>
                            <a class="dropdown-item" href="/producto/compra/pagos/'.$listaFacturas->id.'"> <i class="fa-solid fa-cash-register text-success"></i> Pagos </a>
                        </li>


                        <li>
                            <a class="dropdown-item" href="/inventario/compras/incidencias/'.$listaFacturas->id.'" > <i class="fa-solid fa-triangle-exclamation text-warning"></i> Lista de Incidencias </a>
                        </li>                        

                        
                    </ul>
                </div>';
            })
            ->addColumn('estado_cobro', function ($listaFacturas) {

                if($listaFacturas->monto_pagado >= $listaFacturas->total){

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
