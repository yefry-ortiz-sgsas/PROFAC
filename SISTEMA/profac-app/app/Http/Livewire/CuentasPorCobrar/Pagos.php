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
            /*
             $cuentas = DB::select("select
             factura.id as codigoFactura,
             (RIGHT(factura.cai, 5)) as numero_factura,
             factura.cai as correlativo,
             (
                         IF  (
                              (
                                 SELECT COUNT(*) FROM numero_orden_compra WHERE id = factura.numero_orden_compra_id
                              ) = 0
                              , 'N/A'
                              ,(SELECT numero_orden FROM numero_orden_compra WHERE id = factura.numero_orden_compra_id)

                             )

                         ) as 'numOrden',
             factura.fecha_emision as 'fecha_emision',
             factura.fecha_vencimiento as 'fecha_vencimiento',
             factura.pendiente_cobro as 'saldo'
             from factura
             inner join cliente on (factura.cliente_id = cliente.id)
             where factura.estado_venta_id <> 2 and cliente_id = ".$id." and factura.pendiente_cobro <> 0;");

            */

            $cuentas = DB::select("
                select
                id as                      'codigoPago',
                factura_id as              'codigoFactura',
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
                updated_at  as             'ultimoRegistro'
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
                                        <a class="dropdown-item" href="/venta/cobro/'.$cuenta->codigoFactura.'"> <i class="fa-solid fa-cash-register text-success"></i> Gestionar retencion </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/venta/cobro/'.$cuenta->codigoFactura.'"> <i class="fa-solid fa-cash-register text-success"></i> Creditos/Pago </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/venta/cobro/'.$cuenta->codigoFactura.'"> <i class="fa-solid fa-cash-register text-success"></i> Notas de credito </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/venta/cobro/'.$cuenta->codigoFactura.'"> <i class="fa-solid fa-cash-register text-success"></i> Notas de debito </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/venta/cobro/'.$cuenta->codigoFactura.'"> <i class="fa-solid fa-cash-register text-success"></i> Otros movimientos </a>
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

    public function listarHistoricoSaldoCliente($id){
        try{

            $interes_cuentas = DB::SELECT("
            select
            factura.numero_factura as numero_factura,
            factura.cai as correlativo,
            cliente_id as id_cliente,
            factura.nombre_cliente as 'cliente',
            factura.numero_factura as 'documento',
            factura.fecha_emision as 'fecha_emision',
            factura.fecha_vencimiento as 'fecha_vencimiento',
            factura.total as 'cargo',
            (factura.total-factura.pendiente_cobro) as 'abonos',
            @numeroDias := TIMESTAMPDIFF(DAY, fecha_vencimiento, DATE(NOW()) ) as dias,
            @interesDiario:=0 as interesInicia,
            if(@numeroDias < 0, @interesDiario:=0, FORMAT(@interesDiario:= @numeroDias*0.1083333333,2)) as interesDiario,
            FORMAT((factura.pendiente_cobro + @interesDiario),2) as acumulado

        from factura
        inner join cliente on (factura.cliente_id = cliente.id)
        where   factura.pendiente_cobro <> 0 and cliente_id = '". $id."'");

        return Datatables::of($interes_cuentas)
                ->addColumn('opciones', function ($interes_cuenta) {

                    return

                        '
                <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                    más</button>
                <ul class="dropdown-menu" x-placement="bottom-start"
                    style="position: absolute; top: 33px; left: 0px; will-change: top, left;">


                    <li>
                    <a class="dropdown-item"   ><i class="fa-solid fa-xmark text-danger"></i> Desactivar </a>
                    </li>

                </ul>
            </div>
                ';
                })


                ->rawColumns(['opciones'])
                ->make(true);
        } catch (QueryException $e) {


            return response()->json([
                'message' => 'Ha ocurrido un error al listar las cuentas.',
                'errorTh' => $e,
            ], 402);
        }
    }

    public function exportCuentasPorCobrar($cliente){
        try {


            return Excel::download(new CuentasPorCobrarExport($cliente), 'CuentasPorCobrarCliente.xlsx');

        } catch (QueryException $e) {
            return response()->json([

                'error' => $e,
                "text" => "Ha ocurrido un error.",
                "icon" => "error",
                "title"=>"Error!"
            ],402);
        }
    }

    public function exportCuentasPorCobrarInteres($cliente){
        try {


            return Excel::download(new CuentasPorCobrarInteresExport($cliente), 'CuentasPorCobrarInteresCliente.xlsx');

        } catch (QueryException $e) {
            return response()->json([

                'error' => $e,
                "text" => "Ha ocurrido un error.",
                "icon" => "error",
                "title"=>"Error!"
            ],402);
        }
    }

    public function imprimirEstadoCuenta($idClientepdf){
        $estadoCuenta = DB::select("CALL cuentasx2('".$idClientepdf."');");
        // dd($estadoCuenta[0]->cliente);
        $pdf = PDF::loadView('/pdf/estadocuenta', compact('estadoCuenta'))->setPaper('letter')->setPaper("A4", "landscape");

        return $pdf->stream("estado_cuenta.pdf");
    }
}
