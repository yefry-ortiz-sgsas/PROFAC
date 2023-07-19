<?php

namespace App\Http\Livewire\CierreDiario;

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

use App\Models\ModelFactura;
use App\Models\ModelCAI;
use App\Models\ModelRecibirBodega;
use App\Models\ModelVentaProducto;
use App\Models\ModelLogTranslados;
use App\Models\ModelParametro;
use App\Models\ModelLista;
use App\Models\ModelCliente;
use App\Models\logCredito;
use App\Models\User;

class CierreDiario extends Component
{
    public function render()
    {
        return view('livewire.cierre-diario.cierre-diario');
    }

    public function contado($fecha){
        try {

                //dd($fecha);

            $consulta = DB::SELECT("
                select
                    A.created_at as 'fecha',
                    A.cai as 'factura',
                    A.nombre_cliente as 'cliente',
                    (select name from users where id = A.vendedor) as 'vendedor',
                    A.sub_total as 'subtotal',
                    IF(A.sub_total = A.total, 0.00,A.isv) as 'imp_venta',
                    A.total as 'total',
                    (CASE A.estado_factura_id WHEN '1' THEN 'CLIENTE B' WHEN '2' THEN 'CLIENTE A' END) AS 'tipo',
                    'CONTADO' AS 'tipoFactura'
                from factura A
                    inner join estado_venta B on A.estado_venta_id = B.id
                    inner join tipo_pago_venta C on A.tipo_pago_id = C.id
                where
                    B.id = 1
                    and C.id = 1
                    and A.estado_venta_id = 1
                    and DATE(A.created_at) = DATE_FORMAT('".$fecha."', '%Y-%m-%d');
                ");

            return Datatables::of($consulta)
            ->rawColumns([])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar el reporte solicitado.',
                'errorTh' => $e,
            ], 402);

        }




    }

    public function credito($fecha){
        try {

            $consulta = DB::SELECT("
                select
                    A.created_at as 'fecha',
                    A.cai as 'factura',
                    A.nombre_cliente as 'cliente',
                    (select name from users where id = A.vendedor) as 'vendedor',
                    A.sub_total as 'subtotal',
                    IF(A.sub_total = A.total, 0.00, A.isv) as 'imp_venta',
                    A.total as 'total',
                    (CASE A.estado_factura_id WHEN '1' THEN 'CLIENTE B' WHEN '2' THEN 'CLIENTE A' END) AS 'tipo',
                    'CREDITO' AS 'tipoFactura'
                from factura A
                    inner join estado_venta B on A.estado_venta_id = B.id
                    inner join tipo_pago_venta C on A.tipo_pago_id = C.id
                where
                    B.id = 1
                    and C.id = 2
                    and A.estado_venta_id = 1
                    and DATE(A.created_at) = DATE_FORMAT('".$fecha."', '%Y-%m-%d');
                ");


            return Datatables::of($consulta)
            ->rawColumns([])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar el reporte solicitado.',
                'errorTh' => $e,
            ], 402);

        }

    }

    public function anuladas($fecha){
        try {

            $consulta = DB::SELECT("
                select
                    A.created_at as 'fecha',
                    A.cai as 'factura',
                    A.nombre_cliente as 'cliente',
                    (select name from users where id = A.vendedor) as 'vendedor',
                    A.sub_total as 'subtotal',
                    IF(A.sub_total = A.total, 0.00, A.isv) as 'imp_venta',
                    format(A.total,2) as 'total',
                    (CASE A.estado_factura_id WHEN '1' THEN 'CLIENTE B' WHEN '2' THEN 'CLIENTE A' END) AS 'tipo',
                    'ANULADAS' AS 'tipoFactura'
                from factura A
                    inner join estado_venta B on A.estado_venta_id = B.id
                    inner join tipo_pago_venta C on A.tipo_pago_id = C.id
                where
                    B.id = 1
                    and A.estado_venta_id = 2
                    and DATE(A.created_at) = DATE_FORMAT('".$fecha."', '%Y-%m-%d');
                ");



            return Datatables::of($consulta)
            ->rawColumns([])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar el reporte solicitado.',
                'errorTh' => $e,
            ], 402);

        }

    }

    public function cargaTotales($fecha){



        $anuladoTotal = DB::SELECTONE("
            select
                IF(SUM(A.total) IS NULL, 0.00, SUM(A.total)) as 'sumaTotal'
            from factura A
                inner join estado_venta B on A.estado_venta_id = B.id
                inner join tipo_pago_venta C on A.tipo_pago_id = C.id
            where
                B.id = 1
                and A.estado_venta_id = 2
                and DATE(A.created_at) = DATE_FORMAT('".$fecha."', '%Y-%m-%d');
        ");

        $creditoTotal = DB::SELECTONE("
                select
                    IF(SUM(A.total) IS NULL, 0.00, SUM(A.total)) as 'sumaTotal'
                from factura A
                    inner join estado_venta B on A.estado_venta_id = B.id
                    inner join tipo_pago_venta C on A.tipo_pago_id = C.id
                where
                    B.id = 1
                    and C.id = 2
                    and A.estado_venta_id = 1
                    and DATE(A.created_at) = DATE_FORMAT('".$fecha."', '%Y-%m-%d');
                ");

        $contadoTotal = DB::SELECTONE("
                select
                    IF(SUM(A.total) IS NULL, 0.00, SUM(A.total)) as 'sumaTotal'
                from factura A
                    inner join estado_venta B on A.estado_venta_id = B.id
                    inner join tipo_pago_venta C on A.tipo_pago_id = C.id
                where
                    B.id = 1
                    and C.id = 1
                    and A.estado_venta_id = 1
                    and DATE(A.created_at) = DATE_FORMAT('".$fecha."', '%Y-%m-%d');
                ");



        return response()->json([
            'totalContado' => $contadoTotal->sumaTotal,
            'totalCredito' => $creditoTotal->sumaTotal,
            'totalAnulado' => $anuladoTotal->sumaTotal,
        ], 200);
    }
}
