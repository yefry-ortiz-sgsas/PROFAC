<?php

namespace App\Http\Livewire\NotaCredito;


use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use Validator;
use PDF;
use Luecano\NumeroALetras\NumeroALetras;
class CrearNotaCredito extends Component
{
    public function render()
    {
        return view('livewire.nota-credito.crear-nota-credito');
    }

    public function obtenerClientes(Request $request){

        $clientes = DB::SELECT("select id, concat(id,'-',nombre) as text from cliente where (nombre like '%".$request->search."%') or (id like '%".$request->search."%') limit 15");

        return response()->json([
            "results"=>$clientes,
        ],200);

    }

    public function obtenerFactura(Request $request){

        $clientes = DB::SELECT("select id, cai as text from factura where estado_venta_id = 1 and cliente_id = ".$request->idCliente." and cai like '%".$request->search."%' limit 15");

        return response()->json([
            "results"=>$clientes,
        ],200);

    }

    public function obtenerDetalleFactura(Request $request){

        $datosFactura = DB::SELECTONE("
        select 
        factura.id,
        fecha_emision,
        B.descripcion as tipoPago,
        C.descripcion as tipoFactura,
        D.id as idCliente,
        D.rtn,
        D.nombre as nombreCliente,
        E.name vendedor,
        (select name from users where id = factura.users_id) as facturador,
        factura.created_at as fechaRegistro,
        sub_total,
        total,
        isv

        from factura
        inner join tipo_pago_venta B
        on factura.tipo_pago_id = B.id
        inner join tipo_venta C
        on factura.tipo_venta_id = C.id
        inner join cliente D
        on factura.cliente_id = D.id
        inner join users E
        on factura.vendedor = E.id
        where factura.id = ".$request->idFactura
        );

        return response()->json([
            'datosFactura'=>$datosFactura
        ],200);

    }
}
