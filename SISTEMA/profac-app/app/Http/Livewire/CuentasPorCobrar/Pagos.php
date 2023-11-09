<?php

namespace App\Http\Livewire\CuentasPorCobrar;

use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use DataTables;
use Throwable;
use PDF;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CuentasPorCobrarExport;
use App\Exports\CuentasPorCobrarInteresExport;
class Pagos extends Component
{
    public function render()
    {
        return view('livewire.cuentas-por-cobrar.pagos');
    }

    public function listarClientes(Request $request){
        try {

         //$clientes = DB::SELECT("select id, nombre as text from cliente where estado_cliente_id = 1");//Clientes Activos
         $clientes = DB::SELECT("select id, concat(id,' - ',nombre) as text from cliente where (id LIKE '%".$request->search."%' or nombre Like '%".$request->search."%') limit 15");//Todos los Clientes

        return response()->json([
            'results'=>$clientes,
        ],200);

        } catch (QueryException $e) {
        return response()->json([
         'message' => 'Ha ocurrido un error',
         'error' => $e
        ],402);
        }
    }


    public function listarCuentasPorCobrar($id){
        try{

            /* VALIDANDO EXISTGENCIA DE FACTURAS DE ESTE CLIENTE PARA CLIENTES VIEJOS*/
            $existenciaAplicacion = DB::SELECTONE("

                SELECT COUNT(*) AS existe FROM aplicacion_pagos ap
                inner join factura fa on fa.id = ap.factura_id
                inner join cliente cli on cli.id = fa.cliente_id
                where cli.id = ".$id."


            ");


            if ($existenciaAplicacion->existe == 0) {

                $cuentas2 = DB::select("

                CALL sp_aplicacion_pagos('1','".$id."', '".Auth::user()->id."', '0', @estado, @msjResultado);");

                //dd($cuentas2[0]->estado);

                if ($cuentas2[0]->estado == -1) {
                    return response()->json([
                        "text" => "Ha ocurrido un error al insertar facturas en aplicacion de pagos.",
                        "icon" => "error",
                        "title"=>"Error!"
                    ],402);
                }

            }

            $cuentas = DB::select("
                select
                id as                      'codigoPago',
                factura_id as              'idFactura',
                (select cai
                from factura
                where id = factura_id) as  'codigoFactura',
                total_factura_cargo as     'cargo',
                total_notas_credito as     'notasCredito',
                total_nodas_debito as      'notasDebito',
                credito_abonos as          'abonosCargo',
                movimiento_suma as         'movSuma',
                movimiento_resta as        'movResta',
                retencion_isv_factura as   'isv',
                saldo as                   'saldo',
                estado_retencion_isv as    'estadoRetencion',
                estado as                  'estado',
                usr_cerro as               'usrCierre',
                created_at as              'fechaRegistro',
                updated_at  as             'ultimoRegistro',
                IF(
                   (
                    select
                       COUNT(*)
                    from nota_credito
                    where nota_credito.factura_id = idFactura
                    ) > 0, 1, 0
                ) as                       'tieneNC',
                IF(
                   (
                    select
                       COUNT(*)
                    from notadebito
                    where notadebito.factura_id = idFactura
                    ) > 0, 1, 0
                ) as                       'tieneND'

                from aplicacion_pagos
                where
                cliente_id = ".$id."
                and
                estado = 1;"
            );



        return Datatables::of($cuentas)
                ->addColumn('acciones', function ($cuenta) {

                    return
                        '
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver más</button>
                                <ul class="dropdown-menu" x-placement="bottom-start"
                                    style="position: absolute; top: 33px; left: 0px; will-change: top, left;">


                                    <li>
                                        <a class="dropdown-item" href="/detalle/venta/'.$cuenta->codigoFactura.'" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Detalle de venta </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" onclick="modalRetencion('.$cuenta->codigoPago.' , '.$cuenta->isv.', '.$cuenta->estadoRetencion.', '."'".$cuenta->codigoFactura."'".', '.$cuenta->idFactura.')">  <i class="fa-solid fa-cash-register text-success"></i> Gestionar retencion </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" onclick="modalNotaCredito('.$cuenta->codigoPago.' , '."'".$cuenta->codigoFactura."'".', '.$cuenta->idFactura.', '.$cuenta->tieneNC.')"> <i class="fa-solid fa-cash-register text-success"></i> Notas de credito </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" onclick="modalNotaDebito('.$cuenta->codigoPago.' , '."'".$cuenta->codigoFactura."'".', '.$cuenta->idFactura.', '.$cuenta->tieneND.')"> <i class="fa-solid fa-cash-register text-success"></i> Notas de debito </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" onclick="modalOtrosMovimientos('.$cuenta->codigoPago.' , '."'".$cuenta->codigoFactura."'".', '.$cuenta->idFactura.')"> <i class="fa-solid fa-cash-register text-success"></i> Otros movimientos </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" onclick="modalAbonos('.$cuenta->codigoPago.' , '."'".$cuenta->codigoFactura."'".', '.$cuenta->idFactura.')"> <i class="fa-solid fa-cash-register text-success"></i> Creditos/Pago </a>
                                    </li>



                                </ul>
                            </div>
                        ';
                })


                ->rawColumns(['acciones'])
                ->make(true);
        } catch (QueryException $e) {


            return response()->json([
                'message' => 'Ha ocurrido un error al listar las cuentas.',
                'errorTh' => $e,
            ], 402);
        }
    }

    public function listarMovimientos($id){
        try{

            $consulta = DB::select("

            select
            ot.id as 'codigoMovimiento',
            ot.aplicacion_pagos_id as 'codigoPago',
            (select cai from factura where id = ot.factura_id) as correlativo,
            FORMAT(ot.monto, 2) as monto,
            ot.tipo_movimiento,
            ot.comentario,
            ot.estado as estadoMov,
            (select name from users where id = ot.usr_registro) as userRegistro,
            ot.created_at as fechaRegistro,
            ot.factura_id
                from otros_movimientos ot
                inner join aplicacion_pagos ap on ap.id = ot.aplicacion_pagos_id
                where
                ap.cliente_id = ".$id."
                and ap.estado = 1
                and ot.estado = 1
                ;"
            );



        return Datatables::of($consulta)
                ->addColumn('acciones', function ($consulta) {

                    return
                        '
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver más</button>
                                <ul class="dropdown-menu" x-placement="bottom-start"
                                    style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                                    <li>
                                        <a class="dropdown-item" onclick="inhabilitarMov('.$consulta->codigoMovimiento.')"> <i class="fa-solid fa-arrows-to-eye text-info"></i> Inhabilitar </a>
                                    </li>

                                </ul>
                            </div>
                        ';
                })


                ->rawColumns(['acciones'])
                ->make(true);
        } catch (QueryException $e) {


            return response()->json([
                'message' => 'Ha ocurrido un error al listar las cuentas.',
                'errorTh' => $e,
            ], 402);
        }
    }

    public function listarAbonos($id){
        try{

            $consulta = DB::select("

            select
            ac.id as 'codigoAbono',
            ac.aplicacion_pagos_id as 'codigoPago',
            (select cai from factura where id = ac.factura_id) as correlativo,
            FORMAT(ac.monto_abonado, 2) as monto,
            ac.comentario,
            ac.estado_abono as 'estadoAbono',
            (select name from users where id = ac.usr_registro) as userRegistro,
            ac.created_at as fechaRegistro,
            ac.factura_id
                from abonos_creditos ac
                inner join aplicacion_pagos ap on ap.id = ac.aplicacion_pagos_id
                where
                ap.cliente_id = ".$id."
                and ap.estado = 1
                and ac.estado_abono = 1
                ;"
            );



        return Datatables::of($consulta)
                ->addColumn('acciones', function ($consulta) {

                    return
                        '
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver más</button>
                                <ul class="dropdown-menu" x-placement="bottom-start"
                                    style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                                    <li>
                                        <a class="dropdown-item" onclick="inhabilitarAbono('.$consulta->codigoMovimiento.')"> <i class="fa-solid fa-arrows-to-eye text-info"></i> Inhabilitar </a>
                                    </li>

                                </ul>
                            </div>
                        ';
                })


                ->rawColumns(['acciones'])
                ->make(true);
        } catch (QueryException $e) {


            return response()->json([
                'message' => 'Ha ocurrido un error al listar las cuentas.',
                'errorTh' => $e,
            ], 402);
        }
    }




    public function listarNotasCredito($idFactura){

        try {
                $notasCredito = DB::select("
                    select
                    id as 'idNotaCredito',
                    cai as 'correlativo'
                    from nota_credito where estado_nota_id = 1 and factura_id =
                ".$idFactura);
            return response()->json([
                'results'=>$notasCredito,
            ],200);

        } catch (QueryException $e) {
           return response()->json([
            'message' => 'Ha ocurrido un error',
            'error' => $e
           ],402);
        }

    }

    public function datosNotasCredito($idNotaCredito){

        try {
                $notaCredito = DB::select("
                    select
                    comentario,
                    FORMAT(total,2) AS total,
                    estado_rebajado
                    from nota_credito where id =
                ".$idNotaCredito);
            return response()->json([
                'result'=>$notaCredito,
            ],200);

        } catch (QueryException $e) {
           return response()->json([
            'message' => 'Ha ocurrido un error',
            'error' => $e
           ],402);
        }

    }

    public function listarNotasDebito($idFactura){



        try {
                    $notasDebito = DB::select("
                    select
                    id as 'idNotaDebito',
                    numeroCai as 'correlativo'
                    from notadebito where estado_id = 1 and factura_id =
                ".$idFactura);
            return response()->json([
                'results'=>$notasDebito,
            ],200);

        } catch (QueryException $e) {
           return response()->json([
            'message' => 'Ha ocurrido un error',
            'error' => $e
           ],402);
        }

    }

    public function datosNotasDebito($idNotaDebito){

        try {
                $notaDebito = DB::select("
                    select
                    motivoDescripcion AS 'comentario',
                    FORMAT(monto_asignado,2) AS 'total',
                    estado_sumado
                    from notadebito where id =
                ".$idNotaDebito);
            return response()->json([
                'result'=>$notaDebito,
            ],200);

        } catch (QueryException $e) {
           return response()->json([
            'message' => 'Ha ocurrido un error',
            'error' => $e
           ],402);
        }

    }

}
