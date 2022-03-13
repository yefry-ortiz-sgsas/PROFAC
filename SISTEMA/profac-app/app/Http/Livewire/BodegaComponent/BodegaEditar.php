<?php

namespace App\Http\Livewire\BodegaComponent;

use Livewire\Component;


use App\Models\User;
use App\Models\modelBodega;
use App\Models\Estante;
use App\Models\Repisa;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;
use DataTables;

class BodegaEditar extends Component
{
    public function render()
    {
        return view('livewire.bodega-component.bodega-editar');
    }


    public function listarBodegas(){
        try {
         $listaBodegas = DB::SELECT("
            select
                bodega.nombre as 'numero_bodega',
                bodega.id as 'codigo',
                bodega.direccion,
                users.name as 'encargado',
                estado.descripcion as 'estado'
                from bodega
                inner join users
                on users.id = bodega.encargado_bodega
                inner join estado
                on estado.id = bodega.estado_id

            ");

            return Datatables::of($listaBodegas)
            ->addColumn('opciones', function ($listaBodegas) {
                    return '
                    <div style="position: absolute;" class="dropdown dropdown-action text-right">
                    <a  href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Ver más</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" data-toggle="modal" data-target="#editar_contratos"   ><i class="fa fa-pencil m-r-5 text-warning"></i> Editar</a>
    
                            <a class="dropdown-item" target="_blanck" href=""><i class="fa fa-times text-danger" aria-hidden="true"></i> Desactivar</a>
                        </div>
                    </div>
                    ';
            })
            ->addColumn('estado_bodega', function ($listaBodegas) {
                if ($listaBodegas->estado === 'activo') {
                    return '<td><span class="badge bg-primary">ACTIVO</span></td>';
                } else {
    
                    return '<td><span class="badge bg-danger">INACTIVO</span></td>';
                }
    
                    })
           
            ->rawColumns(['opciones','estado_bodega'])
            ->make(true);


        } catch (QueryException $e) {
        
            return response()->json([
                'message' => 'Ha ocurrido un error, por favor intente de nuevo.',               
                'exception' => $e,
            ],402);
            
        }
    }


}
