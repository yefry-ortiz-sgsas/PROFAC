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
use App\Models\ModelCliente;
use App\Models\ModelFactura;
use App\Models\ModelLogEstadoFactura;
use App\Models\ModelRecibirBodega;
use App\Models\ModelLogTranslados;



class ListadoFacturas extends Component
{
    public function render()
    {
        return view('livewire.ventas.listado-facturas');
    }

    public function listarFacturas(){

        try {
            if(Auth::user()->rol_id  == '1' || Auth::user()->rol_id  == '5' || Auth::user()->rol_id == '3' ){

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
            factura.estado_venta_id,
            factura.created_at as fecha_registro

        from factura
            inner join cliente
            on factura.cliente_id = cliente.id
            inner join tipo_pago_venta
            on factura.tipo_pago_id = tipo_pago_venta.id
            inner join users
            on factura.vendedor = users.id
            inner join cai A
            on factura.cai_id= A.id
            cross join (select @i := 0) r
        where ( YEAR(factura.created_at) >= (YEAR(NOW())-2) )and factura.estado_factura_id=1 and factura.estado_venta_id<>2 and (factura.tipo_venta_id = 1)
        order by factura.created_at desc
            ");

            }else{

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
                factura.estado_venta_id,
                factura.created_at as fecha_registro

            from factura
                inner join cliente
                on factura.cliente_id = cliente.id
                inner join tipo_pago_venta
                on factura.tipo_pago_id = tipo_pago_venta.id
                inner join users
                on factura.vendedor = users.id
                inner join cai A
                on factura.cai_id= A.id
                cross join (select @i := 0) r
            where ( YEAR(factura.created_at) >= (YEAR(NOW())-2) )and factura.estado_factura_id=1 and factura.estado_venta_id<>2 and (factura.tipo_venta_id = 1) and   factura.vendedor = ".Auth::user()->id." order by factura.created_at desc");
            }




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
                            <a class="dropdown-item" target="_blank"  href="/factura/cooporativo/'.$listaFacturas->id.'"> <i class="fa-solid fa-print text-info"></i> Imprimir Factura Original</a>
                            </li>

                            <li>
                            <a class="dropdown-item" target="_blank"  href="/factura/cooporativoCopia/'.$listaFacturas->id.'"> <i class="fa-solid fa-print text-info"></i> Imprimir Factura Copia </a>
                            </li>


                            <li>
                            <a class="dropdown-item" target="_blank"  href="/facturaCoor/actaRec/'.$listaFacturas->id.'"> <i class="fa-solid fa-print text-info"></i> Imprimir Acta de Recepción </a>
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

    public function anularVentaRegistro(Request $request){
        $arrayLog = [];
        try {
        DB::beginTransaction();


         $numeroPagos = DB::SELECTONE("select count(id) as 'numero_pagos' from pago_venta where estado_venta_id = 1 and factura_id = ".$request->idFactura);

         if($numeroPagos->numero_pagos != 0 ){
            return response()->json([
                "text" =>"<p  class='text-left'>Esta factura no puede ser anulada, dado que cuenta con pagos registrados, si desea anular dicha factura debe eliminar todo registro de pago.</p>",
                "icon" => "warning",
                "title" => "Advertencia!",
            ],200);
         }


         $estadoVenta = DB::SELECTONE("select estado_venta_id from factura where id =".$request->idFactura );

         if($estadoVenta->estado_venta_id == 2 ){
            return response()->json([
                "text" =>"<p  class='text-left'>Esta factura no puede ser anulada, dado que ha sido anulada anteriormente.</p>",
                "icon" => "warning",
                "title" => "Advertencia!",
            ],200);
         }




         $compra = ModelFactura::find($request->idFactura);
         $compra->estado_venta_id = 2;
         $compra->save();


         $cliente = ModelCliente::find($compra->cliente_id);
         $cliente->credito = $cliente->credito + $compra->total;
         $cliente->save();



         $logEstado = new ModelLogEstadoFactura;
         $logEstado->factura_id = $request->idFactura;
         $logEstado->estado_venta_id_anterior = $estadoVenta->estado_venta_id;
         $logEstado->users_id = Auth::user()->id;
         $logEstado->motivo = $request->motivo;
         $logEstado->save();

         $lotes = DB::SELECT("select lote,cantidad_s,numero_unidades_resta_inventario,unidad_medida_venta_id from venta_has_producto where factura_id = ".$request->idFactura);

         foreach ($lotes as $lote) {
                $recibidoBodega = ModelRecibirBodega::find($lote->lote);
                $recibidoBodega->cantidad_disponible = $recibidoBodega->cantidad_disponible + $lote->numero_unidades_resta_inventario;
                $recibidoBodega->save();

                array_push($arrayLog,[
                    'origen'=>$lote->lote,
                    'destino'=>$lote->lote,
                    'factura_id'=>$request->idFactura,
                    'cantidad'=>$lote->numero_unidades_resta_inventario,
                    "unidad_medida_venta_id"=>$lote->unidad_medida_venta_id,
                    "users_id"=> Auth::user()->id,
                    "descripcion"=>"Factura Anulada",
                    "created_at"=>now(),
                    "updated_at"=>now(),
                ]);

            };

            ModelLogTranslados::insert($arrayLog);




         DB::commit();
        return response()->json([
            "text" =>"Factura anulada con exito",
            "icon" => "success",
            "title" => "Exito",
        ],200);
        } catch (QueryException $e) {

        DB::rollback();
        return response()->json([
            'message' => 'Ha ocurrido un error',
            'error' => $e
        ], 402);
        }

     }
}
