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

class Proveedores extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.proveedores', compact("users"));
    }
}
