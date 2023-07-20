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

class HistoricoCierres extends Component
{
    public function render()
    {
        return view('livewire.cierre-diario.historico-cierres');
    }

    public function listadoHistorico(){
        try {

            //dd($fecha);

        $consulta = DB::SELECT("
            select
                id, fechaCierre, user_cierre_id,comentario, estado_cierre,totalContado,totalCredito,totalAnulado, created_at
            from bitacoraCierre
            where bitacoraCierre.estado_cierre = 1;
            ");

        return Datatables::of($consulta)
        ->addColumn('acciones', function($consulta){
                return '<a><i class="fas fa-receipt"></i> Prueba</a>';

        })
        ->rawColumns(['acciones'])
        ->make(true);

    } catch (QueryException $e) {
        return response()->json([
            'message' => 'Ha ocurrido un error al listar el reporte solicitado.',
            'errorTh' => $e,
        ], 402);

    }
    }
}
