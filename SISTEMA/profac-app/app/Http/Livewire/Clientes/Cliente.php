<?php

namespace App\Http\Livewire\Clientes;

use Livewire\Component;
use App\Models\User;

class Cliente extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.clientes.cliente');
    }
}
