<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;

class ComisionesComisionar extends Component
{
    public $idVenta;
    public function mount($id)
    {

        $this->idVenta = $id;
    }
    public function render()
    {
        $idFactura = $this->idVenta;
        return view('livewire.comisiones.comisiones-comisionar');
    }

    public function obtenerDesgloseFactura($idFactura){
        return view('livewire.comisiones.comisiones-comisionar');
    }
}
