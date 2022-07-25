<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;

class UnidadesMedida extends Component
{
    public function render()
    {
        return view('livewire.inventario.unidades-medida');
    }
}
