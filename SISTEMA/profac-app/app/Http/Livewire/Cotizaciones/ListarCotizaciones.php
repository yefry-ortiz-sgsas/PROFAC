<?php

namespace App\Http\Livewire\Cotizaciones;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;
use DataTables;

class ListarCotizaciones extends Component


{
    public $tipoVenta=null;


    public function mount($id)
    {

        $this->tipoVenta = $id;
    }


    public function render()
    {

        $tipoVenta = $this->tipoVenta;
        $idTipoVenta = 0;

        switch($tipoVenta){
            case "corporativo":
                    $idTipoVenta = 1;
                    break;
            case "estatal":
                    $idTipoVenta = 2;
                    break;
            case "exonerado":
                    $idTipoVenta = 3;
                    break;

        }

        return view('livewire.cotizaciones.listar-cotizaciones',compact('idTipoVenta'));
    }

    public function listarCotizaciones(Request $request){
        if (Auth::user()->rol_id == '2') {
                $cotizaciones = DB::SELECT("
                select
                A.id,
                concat(YEAR(now()),'-',A.id)  as codigo,
                A.nombre_cliente,
                A.RTN,
                FORMAT(A.sub_total,2) as sub_total,
                FORMAT(A.isv,2) as isv,
                FORMAT(A.total,2) as total,
                B.name,
                A.created_at,
                A.tipo_venta_id
                from cotizacion A
                inner join users B
                on A.users_id = B.id
                where A.tipo_venta_id = ".$request->id."
                and A.vendedor =  ".Auth::user()->id."
                order by A.id desc
            ");
        }else{
                $cotizaciones = DB::SELECT("
                select
                A.id,
                concat(YEAR(now()),'-',A.id)  as codigo,
                A.nombre_cliente,
                A.RTN,
                FORMAT(A.sub_total,2) as sub_total,
                FORMAT(A.isv,2) as isv,
                FORMAT(A.total,2) as total,
                B.name,
                A.created_at,
                A.tipo_venta_id
                from cotizacion A
                inner join users B
                on A.users_id = B.id
                where A.tipo_venta_id = ".$request->id."
                order by A.id desc
            ");

        }


        return Datatables::of($cotizaciones)
            ->addColumn('opciones', function ($cotizacion) {

                if($cotizacion->tipo_venta_id == 1){
                    return
                    '<div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                            más</button>
                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                            <li>
                                <a class="dropdown-item" target="_blank"  href="/cotizacion/facturar/'.$cotizacion->id.'" > <i class="fa-solid fa-file-invoice text-info"></i> Facturar </a>
                            </li>



                            <li>
                                <a class="dropdown-item"  target="_blank" href="/cotizacion/imprimir/'.$cotizacion->id.'">  <i class="fa-solid fa-print text-success"></i> Imprimir Cotización </a>
                            </li>

                            <li>
                            <a class="dropdown-item" target="_blank"  href="/proforma/imprimir/'.$cotizacion->id.'"> <i class="fa-solid fa-print text-success"></i> Imprimir Proforma </a>
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
                            <a class="dropdown-item" target="_blank"  href="/cotizacion/facturar/gobierno/'.$cotizacion->id.'" > <i class="fa-solid fa-file-invoice text-info"></i> Facturar </a>
                        </li>



                        <li>
                            <a class="dropdown-item"  target="_blank" href="/cotizacion/imprimir/'.$cotizacion->id.'">  <i class="fa-solid fa-print text-success"></i> Imprimir Cotización </a>
                        </li>

                        <li>
                        <a class="dropdown-item" target="_blank"  href="/proforma/imprimir/'.$cotizacion->id.'"> <i class="fa-solid fa-print text-success"></i> Imprimir Proforma </a>
                        </li>




                    </ul>
                </div>';
                }


            })

            ->rawColumns(['opciones'])
            ->make(true);
    }

}
