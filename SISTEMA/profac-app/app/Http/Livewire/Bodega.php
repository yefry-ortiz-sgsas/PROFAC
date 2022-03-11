<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Bodega;
use App\Models\Estante;
use App\Models\Repisa;
use App\Models\Seccion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;


class Bodega extends Component
{
    public function render()
    {
        $users = User::all();
      
        return view('livewire.bodega', compact("users"));
    }

    public function crearBodega(Request $request){

        $validator = Validator::make($req->all(), [
            'bodega' => 'required',
            'direccionBodega' => 'required',
            'encargadoBodega' => 'required',
            'bodegaNumEstant' => 'required',
            'bodegaNumRepisa' => 'required',
            'bodegaNumSec' => 'required',
        ], [
            'bodega' => 'Fecha es requerida',
            'direccionBodega' => 'Médico es requerido',
            'encargadoBodega' => 'Clínica es requerida',
            'bodegaNumEstant' => 'Id de paciente es requerido',
            'bodegaNumRepisa' => 'Tipo de atención es requerido',
            'bodegaNumSec' => 'Tipo de atención es requerido',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $crearBodega = new Bodega;
            $crearBodega->nombre = $request->bodega;
            $crearBodega->direccion = $request->direccionBodega;
            $crearBodega->encargado_bodega = $request->encargadoBodega;
            $crearBodega->estado_id = 1;

            for ($i=1; $i <= $request['bodegaNumEstant'] ; $i++) { 

                $crearEstante = new Estante;
                $crearEstante->nombre = $i;
                $crearEstante->id_bodega=  $crearBodega->id;
                

                        for ($j=1; $j <= $request['bodegaNumRepisa'] ; $j++) { 
                            $crearRepisa = new Repisa;
                            $crearRepisa->nombre = $j;
                            $crearRepisa->estante_id = $crearEstante->id;

                                    for ($z=1; $z <=$request['bodegaNumSec'] ; $z++) { 
                                        
                                    }


                        }
               
            }

            








        } catch (Throwable $th) {
            DB::rollback(); 

        }
        





    }
}
