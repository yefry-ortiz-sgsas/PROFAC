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
use App\Model\Model\Modelproveedores;

class Proveedores extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.proveedores', compact("users"));
    }

    public function proveerdoresModelInsert(Request $request){
        /* dd($request->telefono_prov_2); */
            $validator = Validator::make($request->all(), [
                'codigo_prov' => 'required',
                'nombre_prov' => 'required',
                'direccion_prov' => 'required',
                'contacto_prov' => 'required',
                'telefono_prov' => 'required',
                'telefono_prov_2' => 'required',
                'rtn_prov' => 'required',
                'pais_prov' => 'required',
                'depto_prov' => 'required',
                'municipio_prov' => 'required',
                'giro' => 'required',
                'categoria' => 'required',
                'retencion' => 'required',
            ], [
                'codigo_prov' => 'Fecha es requerida',
                'nombre_prov' => 'required',
                'direccion_prov' => 'required',
                'contacto_prov' => 'required',
                'telefono_prov' => 'required',
                'telefono_prov_2' => 'required',
                'rtn_prov' => 'required',
                'pais_prov' => 'required',
                'depto_prov' => 'required',
                'municipio_prov' => 'required',
                'giro' => 'required',
                'categoria' => 'required',
                'retencion' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'mensaje' => 'Ha ocurrido un error.',
                    'errors' => $validator->errors()
                ], 422);
            }
            $crearProveedores = new Modelproveedores;
            $crearProveedores->codigo=$request->codigo_prov;
            $crearProveedores->nombre=$request->nombre_prov;
            $crearProveedores->direccion=$request->direccion_prov;
            $crearProveedores->contacto=$request->contacto_prov;
            $crearProveedores->telefono_1=$request->telefono_prov;
            $crearProveedores->telefono_2=$request->telefono_prov_2;
            $crearProveedores->correo_1=$request->correo_prov;
            $crearProveedores->correo_2=$request->correo_prov_2;
            $crearProveedores->rtn=$request->rtn_prov;
            $crearProveedores->pais=$request->pais_prov;
            $crearProveedores->departamento=$request->depto_prov;
            $crearProveedores->municipio=$request->municipio_prov;
            $crearProveedores->giro=$request->giro_neg_prov;
            $crearProveedores->categoria=$request->categoria_prov;
            $crearProveedores->retencion=$request->retencion_prov;
            $crearProveedores->save();


    }
}
