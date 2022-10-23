<?php

namespace App\Http\Livewire\Vale;

use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use Validator;

class ListarVales extends Component
{
    public function render()
    {
        return view('livewire.vale.listar-vales');
    }

    public function MostrarlistarVales(){
       try {

        $listaVales = DB::SELECT("
        select
         @i := @i + 1 as contador,
          vale.id,
          vale.numero_vale,
          factura.nombre_cliente,
          factura.rtn,
          factura.numero_factura,
          format(vale.sub_total,2) as sub_total,
          format(vale.isv,2) as isv,
          format(vale.total,2) as total,
          (select sum(numero_unidades_pendientes)  from vale_has_producto where vale_id = vale.id) as pendiente_entrega,
          name,
          vale.created_at              
        from vale
        inner join factura
        on vale.factura_id = factura.id
        inner join users
        on vale.users_id = users.id   
        cross join (select @i := 0) r
        where vale.estado_id=1 and   YEAR(vale.created_at) = YEAR(NOW())
        ");

        return Datatables::of($listaVales)
        ->addColumn('opciones', function ($vale) {


                return

                '<div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                        más</button>
                    <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">
                        <li>
                            <a class="dropdown-item" href="#" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Imprimir Vale </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="/vale/crear/factura/'.$vale->id.'"> <i class="fa-solid fa-cash-register text-success"></i> Facturar Vale </a>
                        </li>
                    </ul>
                </div>';
            
        })
        ->addColumn('estado_entrega', function ($vale) {
           

              if($vale->pendiente_entrega == 0){

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
        ->rawColumns(['opciones','estado_entrega'])
        ->make(true);
       } catch (QueryException $e) {
       return response()->json([
        'icon' => '',
        'text' => '',
        'title' => '',
        'message' => 'Ha ocurrido un error', 
        'error' => $e,
       ],402);
       }
    }
}
