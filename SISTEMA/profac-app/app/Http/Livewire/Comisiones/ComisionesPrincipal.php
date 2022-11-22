<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;
use App\Models\usuario;

use DataTables;

class ComisionesPrincipal extends Component
{
    public function render()
    {
        return view('livewire.comisiones.comisiones-principal');
    }

    public function obtenerFacturas($mes,$idVendedor){
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
            sub_total,
            isv,
            total,
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
            cross join (select @i := 0) r
        where ( YEAR(factura.created_at) >= (YEAR(NOW())-2) ) and factura.estado_venta_id<>2 and (factura.tipo_venta_id = 1) and factura.vendedor = 9
        order by factura.created_at desc
            ");
    }
}
