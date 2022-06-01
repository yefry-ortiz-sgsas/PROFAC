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

class DetalleVenta extends Component
{
    public $idVenta;
    public function mount($id)
    {

        $this->idVenta = $id;
    }
    public function render()

    {
        $detalleVenta=DB::SELECTONE("select 
        A.id,
        A.numero_factura,
        A.cai,
        A.nombre_cliente,
        A.rtn,
        A.sub_total,
        A.isv,
        A.total,
        A.fecha_emision,
        A.fecha_vencimiento,
        B.descripcion as tipo_pago,
        C.descripcion as estado_venta,
        users.name,
        A.monto_comision,
        E.descripcion as tipo_venta,
        A.comision_estado_pagado,
        F.numero_inicial,
        F.numero_final,
        F.fecha_limite_emision
      from factura A
      inner join tipo_pago_venta B
      on A.tipo_pago_id = B.id
      inner join estado_venta C
      on A.estado_venta_id = C.id
      inner join cliente D
      on A.cliente_id = D.id
      inner join users
      on users.id = A.vendedor
      inner join tipo_venta E
      on A.tipo_venta_id = E.id
      inner join cai F
      on A.cai_id = F.id
      where A.id = ".$this->idVenta);

        return view('livewire.ventas.detalle-venta', compact('detalleVenta'));
    }
}
