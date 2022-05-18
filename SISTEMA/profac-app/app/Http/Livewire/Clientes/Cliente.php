<?php

namespace App\Http\Livewire\Clientes;

use Livewire\Component;
use App\Models\User;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class Cliente extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.clientes.cliente');
    }

    public function opbtenerPais(){

        $listaPais = DB::SELECT("select id, nombre from pais");

        return response()->json([
            'listaPais' => $listaPais 
        ],200);

    }

    public function obtenerDepartamentos(Request $request){

        $listaDeptos = DB::SELECT("
        select id , nombre from departamento where pais_id =". $request['id']
        );

        return response()->json([
            'listaDeptos' => $listaDeptos 
        ],200);

    }

    public function obtenerMunicipio(Request $request){
        $listaMunicipios = DB::SELECT("
        select * from municipio where departamento_id = ". $request['id']
        );

        return response()->json([
            'listaMunicipios' => $listaMunicipios
        ],200);        
    }

    public function tipoPersonalidad(){
        $tipoPersonalidad = DB::SELECT("
        select id,nombre from tipo_personalidad
        ");

        return response()->json([
            'tipoPersonalidad' => $tipoPersonalidad
        ],200);     
    }

    public function tipoCliente(){
        $tipoCliente = DB::SELECT("
        select id, descripcion from tipo_cliente
        ");

        return response()->json([
            'tipoCliente' => $tipoCliente
        ],200);     
    }

    public function listaVendedores(){
        $vendedor = DB::SELECT("
        select id, name from users where rol_id = 2
        ");

        return response()->json([
            'vendedor' => $vendedor
        ],200);   
    }

    public function guardarCliente(){
       try {

        

       return response()->json([
       ]);
       } catch (QueryException $e) {
       return response()->json([
           'message' => 'Ha ocurrido un error', 
           'error' => $e
       ]);
       }
    }
}
