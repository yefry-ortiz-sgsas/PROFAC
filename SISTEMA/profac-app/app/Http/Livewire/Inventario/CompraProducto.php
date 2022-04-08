<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

use App\Models\ModelTipoPago;


use App\Models\Modelproveedores;


class CompraProducto extends Component
{
    public function render()
    {
        return view('livewire.inventario.compra-producto');
    }

    public function listarProveedores(Request $request){

        try {

            $proveedores = DB::SELECT("select id, concat(id,' - ',nombre) as text  from proveedores where id LIKE '%".$request->search."%' or nombre Like '%".$request->search."%'");
            
            return response()->json([
                "results" => $proveedores,
            ], 200);
        } catch (QueryException $e) {
            DB::rollback();

            return response()->json([
                'message' => 'Ha ocurrido un error al listar los proveedores.',
                'errorTh' => $e,
            ], 402);
        }
    }

    public function listarFormasPago(){
        try {

            $tipos = ModelTipoPago::all();

            return response()->json([
                "tipos" =>  $tipos,

            ],200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar los tipos de pago.',
                'errorTh' => $e,
            ], 402);
        }
    }
}
