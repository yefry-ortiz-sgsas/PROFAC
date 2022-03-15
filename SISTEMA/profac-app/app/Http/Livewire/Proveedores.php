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
use App\Models\Modelproveedores;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\TipoPersonalidad;
use App\Models\Categoria;
use App\Models\Retenciones;



class Proveedores extends Component
{
    public function render()
    {
        $users = User::all();
        $paises = Pais::all();
        $categorias = Categoria::all();
        $retenciones = Retenciones::all();
        $tipoPersonalidad = TipoPersonalidad::all();


       
        return view('livewire.proveedores', compact("users","paises","categorias","retenciones","tipoPersonalidad"));
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
                'giro_neg_prov' => 'required',
                'categoria_prov' => 'required',
                'retencion_prov' => 'required',
            ], [
                'codigo_prov' => 'Codigo es requerido',
                'nombre_prov' => 'nombre es requerido',
                'direccion_prov' => 'Direccion es requerido',
                'contacto_prov' => 'Contacto es requerido',
                'telefono_prov' => 'Telefono es requerido',
                'telefono_prov_2' => 'Telefono 2 es requerido',
                'rtn_prov' => 'RTN es requerido',
                'pais_prov' => 'País es requerido',
                'depto_prov' => 'Departamento es requerido',
                'municipio_prov' => 'Municipio es requerido',
                'giro_neg_prov' => 'Giro es requerido',
                'categoria_prov' => 'Categoria es requerido',
                'retencion_prov' => 'Retencion es requerido',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'mensaje' => 'Ha ocurrido un error.',
                    'errors' => $validator->errors()
                ], 422);
            }
         

            try {

                DB::beginTransaction();

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
                $crearProveedores->registrado_por=Auth::user()->id;
                $crearProveedores->estado_id=1;
                $crearProveedores->save();

                DB::commit();

                return response()->json([
                    'message' => 'Creado con exito.',                   
                ], 200); 
               
            } catch (QueryException $e) {

                DB::rollback(); 
         
                return response()->json([
                    'message' => 'Ha ocurrido un error.',
                    'errorTh' => $e,
                 
                  
                ], 402);  
                
            }


    }

    public function obtenerDepartamentos(Request $request){
      
        try {
           
            // $departamentos = Departamento::where('pais_id','=',$request['id'])
            //                 ->SELECT("id","UPPER(nombre)")
            //                 ->get();
            $departamentos = DB::SELECT("
            select id, CONCAT(UPPER(SUBSTRING(nombre,1,1)),LOWER(SUBSTRING(nombre,2))) as 'nombre' from departamento where pais_id=".$request['id']."
            ");


            return response()->json([
                "departamentos" => $departamentos,
            ],200);

        } catch (QueryException $e) {
            return response()->json([
                "message" => "Ha ocurrido un error al obtener los departamentos",
                "error" => $e
            ],402);
          
        }
    }

    public function obtenerMunicipios(Request $request){
      
        try {
           
            // $departamentos = Departamento::where('pais_id','=',$request['id'])
            //                 ->SELECT("id","UPPER(nombre)")
            //                 ->get();
            $municipios = DB::SELECT("
            select id, CONCAT(UPPER(SUBSTRING(nombre,1,1)),LOWER(SUBSTRING(nombre,2))) as 'nombre' from municipio where departamento_id=".$request['id']."
            ");


            return response()->json([
                "departamentos" => $municipios,
            ],200);

        } catch (QueryException $e) {
            return response()->json([
                "message" => "Ha ocurrido un error al obtener los municipios",
                "error" => $e
            ],402);
          
        }
    }
}
