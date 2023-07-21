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

use App\Models\CierreDiario as ModelCierreDiario;
use App\Models\bitacoraCierre;

class CierreDiario extends Component
{
    public function render(){
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
                IF(SUM(A.total) IS NULL, 0.00, SUM(A.total)) as 'sumaTotalanulado'
            from factura A
                inner join estado_venta B on A.estado_venta_id = B.id
                inner join tipo_pago_venta C on A.tipo_pago_id = C.id
            where
                B.id = 1
                and A.estado_venta_id = 2
                and DATE(A.created_at) = DATE_FORMAT('".$fecha."', '%Y-%m-%d');"
        );

        $creditoTotal = DB::SELECTONE("
                select
                    IF(SUM(A.total) IS NULL, 0.00, SUM(A.total)) as 'sumaTotalcredito'
                from factura A
                    inner join estado_venta B on A.estado_venta_id = B.id
                    inner join tipo_pago_venta C on A.tipo_pago_id = C.id
                where
                    B.id = 1
                    and C.id = 2
                    and A.estado_venta_id = 1
                    and DATE(A.created_at) = DATE_FORMAT('".$fecha."', '%Y-%m-%d');
                "
        );

        $contadoTotal = DB::SELECTONE("
                select
                    IF(SUM(A.total) IS NULL, 0.00, SUM(A.total)) as 'sumaTotalcontado'
                from factura A
                    inner join estado_venta B on A.estado_venta_id = B.id
                    inner join tipo_pago_venta C on A.tipo_pago_id = C.id
                where
                    B.id = 1
                    and C.id = 1
                    and A.estado_venta_id = 1
                    and DATE(A.created_at) = DATE_FORMAT('".$fecha."', '%Y-%m-%d');
                "
        );

        $existencia = DB::SELECTONE("
                select
                    count(*) as existe
                from bitacoracierre
                where
                    DATE(bitacoracierre.fechaCierre) = DATE_FORMAT('".$fecha."', '%Y-%m-%d')
                    AND bitacoracierre.estado_cierre = 1;
                "
        );



        return response()->json([
            'totalContado' => $contadoTotal->sumaTotalcontado,
            'totalCredito' => $creditoTotal->sumaTotalcredito,
            'totalAnulado' => $anuladoTotal->sumaTotalanulado,
            'banderaCierre'=> $existencia->existe
        ], 200);
    }

    public function guardarCierre($fecha, Request $request){
        try {

            $existencia = DB::SELECTONE("
                select
                    count(*) as existe
                from bitacoracierre
                where
                    DATE(bitacoracierre.fechaCierre) = DATE_FORMAT('".$fecha."', '%Y-%m-%d')
                    AND bitacoracierre.estado_cierre = 1;
                "
            );

            if ($existencia->existe > 0) {
                return response()->json([
                    "icon" => "error",
                    "text" => "Existen registros de cierre de caja para la fecha ".$fecha,
                    "title"=>"Error!",
                    "error" => $e
                ],402);
            }

            if ($existencia->existe === 0) {
                $userName1 = Auth::user()->name;
                $estadoDescripcion1 = 'CERRADO';

                DB::beginTransaction();

                    $fbitacoraCierre = new bitacoraCierre;
                            $fbitacoraCierre->fechaCierre =  $fecha;
                            $fbitacoraCierre->user_cierre_id = Auth::user()->id;
                            $fbitacoraCierre->comentario = $request->comentario ;
                            $fbitacoraCierre->estado_cierre= 1 ;
                            $fbitacoraCierre->totalContado = $request->inputTotalContado ;
                            $fbitacoraCierre->totalCredito = $request->inputTotalCredito ;
                            $fbitacoraCierre->totalAnulado = $request->inputTotalAnulado ;
                    $fbitacoraCierre->save();



                    $contado = DB::SELECT("
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

                    $credito = DB::SELECT("
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

                    $anuladas = DB::SELECT("
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



                    foreach ($contado as $value) {
                        $fcontado = new ModelCierreDiario;

                            $fcontado->user_cierre_id = Auth::user()->id ;
                            $fcontado->estado_cierre = 1 ;
                            $fcontado->nombre_userCierre = TRIM($userName1) ;
                            $fcontado->estadoDescripcion = TRIM($estadoDescripcion1) ;
                            $fcontado->fecha = TRIM($value->fecha) ;
                            $fcontado->factura= TRIM($value->factura) ;
                            $fcontado->cliente = TRIM($value->cliente) ;
                            $fcontado->vendedor = TRIM($value->vendedor) ;
                            $fcontado->subtotal = TRIM($value->subtotal) ;
                            $fcontado->imp_venta = TRIM($value->imp_venta) ;
                            $fcontado->total = TRIM($value->total) ;
                            $fcontado->tipo = TRIM($value->tipo) ;
                            $fcontado->tipoFactura = TRIM($value->tipoFactura) ;
                            $fcontado->bitacoraCierre_id =  $fbitacoraCierre->id ;

                        $fcontado->save();

                    };

                    foreach ($credito as $valuecredito) {

                        $fcredito = new ModelCierreDiario;
                            $fcredito->user_cierre_id = Auth::user()->id ;
                            $fcredito->estado_cierre = 1 ;
                            $fcredito->nombre_userCierre = TRIM($userName1) ;
                            $fcredito->estadoDescripcion = TRIM($estadoDescripcion1) ;
                            $fcredito->fecha = TRIM($valuecredito->fecha) ;
                            $fcredito->factura= TRIM($valuecredito->factura) ;
                            $fcredito->cliente = TRIM($valuecredito->cliente) ;
                            $fcredito->vendedor = TRIM($valuecredito->vendedor) ;
                            $fcredito->subtotal = TRIM($valuecredito->subtotal) ;
                            $fcredito->imp_venta = TRIM($valuecredito->imp_venta) ;
                            $fcredito->total = TRIM($valuecredito->total) ;
                            $fcredito->tipo = TRIM($valuecredito->tipo) ;
                            $fcredito->tipoFactura = TRIM($valuecredito->tipoFactura) ;
                            $fcredito->bitacoraCierre_id =  $fbitacoraCierre->id ;
                        $fcredito->save();

                    };

                    foreach ($anuladas as $valueanuladas) {
                        $fanuladas = new ModelCierreDiario;

                            $fanuladas->user_cierre_id = Auth::user()->id ;
                            $fanuladas->estado_cierre = 1 ;
                            $fanuladas->nombre_userCierre = TRIM($userName1) ;
                            $fanuladas->estadoDescripcion = TRIM($estadoDescripcion1) ;
                            $fanuladas->fecha = TRIM($valueanuladas->fecha) ;
                            $fanuladas->factura= TRIM($valueanuladas->factura) ;
                            $fanuladas->cliente = TRIM($valueanuladas->cliente) ;
                            $fanuladas->vendedor = TRIM($valueanuladas->vendedor) ;
                            $fanuladas->subtotal = TRIM($valueanuladas->subtotal) ;
                            $fanuladas->imp_venta = TRIM($valueanuladas->imp_venta) ;
                            $fanuladas->total = TRIM($valueanuladas->total) ;
                            $fanuladas->tipo = TRIM($valueanuladas->tipo) ;
                            $fanuladas->tipoFactura = TRIM($valueanuladas->tipoFactura) ;
                            $fanuladas->bitacoraCierre_id =  $fbitacoraCierre->id ;

                        $fanuladas->save();


                    };

                DB::commit();
                return response()->json([
                    "icon" => "success",
                    "text" => "Se realizó correctamente la transacción!",
                    "title"=>"Exito!"
                ],200);
            }

        } catch (QueryException $e) {
            DB::rollback();
            return response()->json([
                "icon" => "error",
                "text" => "Ha ocurrido un error al realizar la transacción.",
                "title"=>"Error!",
                "error" => $e
            ],402);
        }
    }
}
