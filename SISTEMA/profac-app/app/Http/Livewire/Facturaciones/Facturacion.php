<?php

namespace App\Http\Livewire\Facturaciones;

use Livewire\Component;
use App\Models\User;




class Facturacion extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.facturaciones.facturacion');
    }


}
