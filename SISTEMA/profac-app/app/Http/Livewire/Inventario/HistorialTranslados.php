<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;

class HistorialTranslados extends Component
{
    public function render()
    {
        
        $fechaActual = date('n');
        $resta = $fechaActual - 2;
        if($resta<=0){
            $resta=12;
        }

        if($resta<10){
            $resta = '0'.$resta;
        }

        $fechaInicio = date('Y').'-'.$resta.'-01';
        return view('livewire.inventario.historial-translados',compact('fechaInicio'));
    }

    public function historialTranslados(){

    }

    
}
