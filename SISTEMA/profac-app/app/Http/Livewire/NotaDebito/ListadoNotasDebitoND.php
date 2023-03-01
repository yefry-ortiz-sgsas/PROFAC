<?php

namespace App\Http\Livewire\NotaDebito;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\QueryException;

class ListadoNotasDebitoND extends Component
{
    public function render()
    {
        $fechaActual = date('n');
        $resta = $fechaActual - 2;

        $mesActual =0;
        $AnioActual = date('Y');

        if($resta<=0){
            $mesActual=12;
            $AnioActual = $AnioActual - 1;
        }elseif($resta>0 && $resta<10){
            $mesActual = '0'.$resta;
        }else{
            $mesActual = date('m');
        }


        $fechaInicio = $AnioActual.'-'.$mesActual.'-01';

        return view('livewire.nota-debito.listado-notas-debito-nd',compact('fechaInicio'));
    }

    public function listarnotasDebito($fechaInicio,$fechaFinal){
        try {

            $listanotaDebito = DB::SELECT("
            select
            notadebito.id
            ,factura_id
            ,factura.numero_factura
            ,monto_asignado
            ,fechaEmision
            ,motivoDescripcion
            ,cai_ndebito
            ,numeroCai
            ,correlativoND
            ,(select name from users where id = notadebito.users_registra_id) as 'user'
            ,notadebito.created_at
            from notadebito
            inner join factura
            on notadebito.factura_id = factura.id
            where estado_nota_dec = 2 and notadebito.created_at >= '".$fechaInicio."' or notadebito.created_at <= '".$fechaFinal."'"
            );

            return Datatables::of($listanotaDebito)
            ->addColumn('estado', function ($listanotaDebito) {
                $ESTADO = DB::SELECTONE("select estado_id from notadebito where id = ".$listanotaDebito->id);
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
}
