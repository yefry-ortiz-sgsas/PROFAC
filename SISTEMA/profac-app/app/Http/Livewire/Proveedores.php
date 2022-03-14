<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;
use App\Models\User;
use App\Models\proveedores as proveerdoresModel;

class Proveedores extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.proveedores', compact("users"));
    }

    public function proveerdoresModelInsert(Request $request){
        dd($request);
        $validator = Validator::make($request->all(), [
            'codigo' => 'required',
            'nombre' => 'required',
            'direccion' => 'required',
            'contacto' => 'required',
            'telefono_1' => 'required',
            'correo_1' => 'required',
            'rtn' => 'required',
            'pais' => 'required',
            'departamento' => 'required',
            'municipio' => 'required',
            'giro' => 'required',
            'categoria' => 'required',
            'retencion' => 'required',
        ], [
            'codigo' => 'Este campo es obligatorio.',
            'nombre' => 'Este campo es obligatorio.',
            'direccion' => 'Este campo es obligatorio.',
            'contacto' => 'Este campo es obligatorio.',
            'telefono_1' => 'Este campo es obligatorio.',
            'correo_1' => 'Este campo es obligatorio.',
            'rtn' => 'Este campo es obligatorio.',
            'pais' => 'Este campo es obligatorio.',
            'departamento' => 'Este campo es obligatorio.',
            'municipio' => 'Este campo es obligatorio.',
            'giro' => 'Este campo es obligatorio.',
            'categoria' => 'Este campo es obligatorio.',
            'retencion' => 'Este campo es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error.',
                'errors' => $validator->errors()
            ], 422);
        }else{
            $crearBodega = new proveerdoresModel;
            $crearBodega->nombre = $request->bodega;
            $crearBodega->direccion = $request->direccionBodega;
            $crearBodega->encargado_bodega = $request->encargadoBodega;
            $crearBodega->estado_id = 1;
            $crearBodega->save();
        }

    }
}
