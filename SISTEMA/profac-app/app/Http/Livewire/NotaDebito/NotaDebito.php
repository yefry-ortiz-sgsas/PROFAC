<?php

namespace App\Http\Livewire\NotaDebito;

use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;

use PDF;
use App\Models\NotaDebito\montoNotaDebito;
use App\Models\NotaDebito\notaDebito as mNotaDebito;
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

class NotaDebito extends Component
{
    public function render(){
        $cai_nd_existencia = DB::SELECTONE("select count(id) as 'existe' from cai where cai.tipo_documento_fiscal_id = 4 and cai.estado_id = 1 and cai.cantidad_no_utilizada > 0");
        return view('livewire.nota-debito.nota-debito', compact('cai_nd_existencia'));
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

                $existencianDebito = DB::SELECTONE("select COUNT(factura_id) as 'existe' from notadebito
                where notadebito.factura_id = ".$listaFacturas->id." and notadebito.estado_id = 1");


                    if ($existencianDebito->existe == 0) {

                        $montoDebito = DB::SELECTONE("select monto, id from montoNotaDebito where estado_id = 1");

                        return

                        '<div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                                más</button>
                            <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                                <li>
                                    <a class="dropdown-item" onclick="llenadoModalDebito('.$listaFacturas->id.', '.$montoDebito->monto.', '.$montoDebito->id.')" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Asignar Noda Débito </a>
                                </li>

                            </ul>
                        </div>';
                    }else{
                        return

                        '<div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                                más</button>
                            <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                                <li>
                                    <a class="dropdown-item" href="/debito/imprimir/'.$listaFacturas->id.'" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Imprimir Nota Débito </a>
                                </li>

                            </ul>
                        </div>';
                    }

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
           ->addColumn('estado_ndebito', function ($listaFacturas) {

                $existencianDebito = DB::SELECTONE("select COUNT(factura_id) as 'existe' from notadebito
                where notadebito.factura_id = ".$listaFacturas->id." and notadebito.estado_id = 1");
               if( $existencianDebito->existe == 0 ){
                   return
                   '
                   <p class="text-center"><span class="badge badge-danger p-2" style="font-size:0.75rem">Nota Sin Asignar</span></p>
                   ';

               }else{

                return
                '

                <p class="text-center" ><span class="badge badge-primary p-2" style="font-size:0.75rem">Nota Asignada</span></p>
                ';
               }

          })
            ->rawColumns(['opciones','estado_cobro','estado_ndebito'])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar las compras.',
                'errorTh' => $e,
            ], 402);

        }

    }

    public function listarMontos(){
        try {

            $listaMontos = DB::SELECT("
                select
                id,
                monto,
                descripcion,
                (select name from users where id = montoNotaDebito.users_registra_id) as 'user',
                created_at
                from montoNotaDebito
            ");

            return Datatables::of($listaMontos)
            ->addColumn('estado_monto', function ($listaMontos) {
                $ESTADOmONTO = DB::SELECTONE("select estado_id from montoNotaDebito where id = ".$listaMontos->id);
                if( $ESTADOmONTO->estado_id == 1){

                    return
                    '
                    <p class="text-center" ><span class="badge badge-primary p-2" style="font-size:0.75rem">Activo</span></p>
                    ';

                }else if($ESTADOmONTO->estado_id == 2) {
                    return
                    '
                    <p class="text-center"><span class="badge badge-danger p-2" style="font-size:0.75rem">Inactivo</span></p>
                    ';
                }

           })
            ->rawColumns(['estado_monto'])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar los montos.',
                'errorTh' => $e,
            ], 402);

        }
    }

    public function guardarMonto(Request $request){
        try {
            DB::beginTransaction();

                DB::update('
                update
                montoNotaDebito
                set estado_id = 2');

                $montoNotaDebito = new montoNotaDebito;
                $montoNotaDebito->monto = $request->monto;
                $montoNotaDebito->descripcion = $request->descripcion;
                $montoNotaDebito->estado_id = 1;
                $montoNotaDebito->users_registra_id = Auth::user()->id;
                $montoNotaDebito->save();

            DB::commit();
            return response()->json([
                "icon" => "success",
                "text" => "Registro de monto de débito con éxito!",
                "title"=>"Exito!"
            ],200);

        } catch (QueryException $e) {
            DB::rollback();
            return response()->json([
                "icon" => "error",
                "text" => "Ha ocurrido un error al registrar el débito.",
                "title"=>"Error!",
                "error" => $e
            ],402);
        }
    }

    public function guardarNotaDebito(Request $request){

        $cai = DB::SELECTONE("select
        id,
        numero_inicial,
        numero_final,
        cantidad_otorgada,
        numero_actual
        from cai
        where tipo_documento_fiscal_id = 4 and estado_id = 1");

        if($cai->numero_actual > $cai->cantidad_otorgada){

            return response()->json([
                "title" => "Advertencia",
                "icon" => "warning",
                "text" => "La Nota de débito no puede proceder, debido que ha alcanzadado el número maximo de unidades CAI.",
            ], 401);

        }
        $numeroSecuencia = $cai->numero_actual;
        $arrayCai = explode('-',$cai->numero_final);
        $cuartoSegmentoCAI = sprintf("%'.08d", $numeroSecuencia);
        $numeroCAI = $arrayCai[0].'-'.$arrayCai[1].'-'.$arrayCai[2].'-'.$cuartoSegmentoCAI;
        $fechaActual = date('Y');
        $correlativo = $fechaActual.'-'.$numeroSecuencia;

        /* GUARDANDO LO DE LA NOTA DE DÉBITO */


        $NotaDebito = new mNotaDebito;
        $NotaDebito->factura_id = $request->factura_id;
        $NotaDebito->montoNotaDebito_id = $request->montoNotaDebito_id;
        $NotaDebito->monto_asignado = $request->monto_;
        $NotaDebito->fechaEmision = $request->fechaEmision;
        $NotaDebito->motivoDescripcion = $request->motivoDescripcion;
        $NotaDebito->cai_ndebito = $cai->id;
        $NotaDebito->numeroCai = $numeroCAI;
        $NotaDebito->correlativoND = $correlativo;
        $NotaDebito->estado_id = 1;
        $NotaDebito->users_registra_id = Auth::user()->id;
        $NotaDebito->save();



        /* //////////////////////////////////////////////////////*/

        $caiUpdated =  ModelCAI::find($cai->id);
        $caiUpdated->numero_actual=$numeroSecuencia+1;
        $caiUpdated->cantidad_no_utilizada=$cai->cantidad_otorgada - $numeroSecuencia;
        $caiUpdated->save();
    }

    public function listarnotasDebito(){
        try {

            $listanotaDebito = DB::SELECT("
                select
                id
                ,factura_id
                ,monto_asignado
                ,fechaEmision
                ,motivoDescripcion
                ,cai_ndebito
                ,numeroCai
                ,correlativoND
                ,(select name from users where id = notaDebito.users_registra_id) as 'user'
                ,created_at
                from notaDebito
            ");

            return Datatables::of($listanotaDebito)
            ->addColumn('estado', function ($listanotaDebito) {
                $ESTADO = DB::SELECTONE("select estado_id from notaDebito where id = ".$listanotaDebito->id);
                if( $ESTADO->estado_id == 1){

                    return
                    '
                    <p class="text-center" ><span class="badge badge-primary p-2" style="font-size:0.75rem">Activo</span></p>
                    ';

                }else if($ESTADO->estado_id == 2) {
                    return
                    '
                    <p class="text-center"><span class="badge badge-danger p-2" style="font-size:0.75rem">Inactivo</span></p>
                    ';
                }

           })
           ->addColumn('file', function ($listanotaDebito) {

                    return
                    '
                        <a class="btn btn-success" href="/debito/imprimir/'.$listanotaDebito->factura_id.'" > Ver <i class="fa-solid fa-file-pdf"></i></a>
                    ';

            })
            ->rawColumns(['estado','file'])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar las notas de debito.',
                'errorTh' => $e,
            ], 402);

        }
    }

    public function descargarNota($idFactura){

            $notaDebito = DB::SELECTONE("
                select
                    id
                    ,factura_id
                    ,monto_asignado
                    ,fechaEmision
                    ,motivoDescripcion
                    ,cai_ndebito
                    ,numeroCai
                    ,correlativoND
                    ,(select name from users where id = notaDebito.users_registra_id) as 'user'
                    ,created_at
                from notaDebito
                where
                notaDebito.estado_id = 1 and notaDebito.factura_id = ".$idFactura
            );

            $cai = DB::SELECTONE("select
                *
            from cai
            where tipo_documento_fiscal_id = 4 and estado_id = 1 and id = ".$notaDebito->cai_ndebito);


            $cliente = DB::SELECTONE("select nombre_cliente, cai, estado_factura_id, numero_factura   from factura where id = ".$idFactura);

            $formatter = new NumeroALetras();
            $formatter->apocope = true;
            $numeroLetras = $formatter->toMoney($notaDebito->monto_asignado, 2, 'LEMPIRAS', 'CENTAVOS');

            $montoConCentavos= DB::SELECTONE("
            select
                FORMAT(monto_asignado,2) as total
            from notaDebito where factura_id = ".$idFactura);

            $pdf = PDF::loadView('/pdf/nodaDeDebito', compact('numeroLetras','notaDebito', 'cliente', 'cai', 'montoConCentavos'))->setPaper('letter');

            return $pdf->stream("nota_debito_" . $notaDebito->factura_id.".pdf");

    }
}
