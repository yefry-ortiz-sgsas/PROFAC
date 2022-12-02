<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use App\Models\Comisiones\desglose;


class ComisionesComisionar extends Component
{
    public $idVenta;
    public function mount($id)
    {

        $this->idVenta = $id;
    }
    public function render()
    {
        $idFactura = $this->idVenta;


        return view('livewire.comisiones.comisiones-comisionar', compact('idFactura'));
        //return view('livewire.comisiones.comisiones-comisionar');
    }



    public function obtenerDesglose($id){
        //dd($id);
        try {
            $listaProd = DB::SELECT("
            SELECT * FROM desglose where idFactura = ".$id."
            ");
            return Datatables::of($listaProd)
            ->addColumn('acciones', function ($listaProd) {
                    return

                    '<div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Ver
                            más</button>
                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 33px; left: 0px; will-change: top, left;">

                            <li>
                                <a class="dropdown-item" href="ir('.$listaProd->idFactura.')" > <i class="fa-solid fa-arrows-to-eye text-info"></i> Ver </a>
                            </li>

                        </ul>
                    </div>';
            })
            ->rawColumns(['acciones'])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar los productos.',
                'errorTh' => $e,
            ], 402);

        }
    }
}
