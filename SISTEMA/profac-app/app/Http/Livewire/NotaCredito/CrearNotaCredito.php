<?php

namespace App\Http\Livewire\NotaCredito;


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
class CrearNotaCredito extends Component
{
    public function render()
    {
        return view('livewire.nota-credito.crear-nota-credito');
    }

    public function obtenerClientes(Request $request){

        $clientes = DB::SELECT("select id, concat(id,'-',nombre) as text from cliente where (nombre like '%".$request->search."%') or (id like '%".$request->search."%') limit 15");

        return response()->json([
            "results"=>$clientes,
        ],200);

    }
}
