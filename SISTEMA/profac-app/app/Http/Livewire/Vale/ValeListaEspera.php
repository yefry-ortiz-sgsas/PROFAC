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
use PDF;
use Luecano\NumeroALetras\NumeroALetras;

use App\Models\ModelFactura;

use App\Models\ModelRecibirBodega;
use App\Models\ModelVentaProducto;
use App\Models\ModelLogTranslados;
use App\Models\ModelCliente;
use App\Models\logCredito;
use App\Models\User;

use App\Models\ModelVale;
use App\Models\ModelValeHasProducto;

class ValeListaEspera extends Component
{




    public function render()
    {
       

        return view('livewire.vale.vale-lista-espera');
    }

    public function obtenerProductosVale(Request $request){
       try {

      
        $productos = DB::SELECT("
        select 
        id,
        concat('cod ',id,' - ',nombre) as text
        from producto
        where nombre like '%". $request->search ."%' or id like '% . $request->search .%' 
        limit 15
        ");

        return response()->json([
            "results" => $productos
        ], 200);
     
       } catch (QueryException $e) {
       return response()->json([
        'icon' => 'error',
        'text' => 'Ha ocurrido un error al listar los productos',
        'title' => 'Error!',
        'message' => 'Ha ocurrido un error', 
        'error' => $e,
       ],402);
       }
    }
    
    public function guardarVale(Request $request){
        dd( $request->all());
    }
}
