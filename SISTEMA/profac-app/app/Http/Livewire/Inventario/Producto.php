<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Database\QueryException;
use Throwable;


use App\Models\ModelUnidadMedida;
use App\Models\ModelCategoriaProducto;

class Producto extends Component
{
    public function render()
    {
        $categorias = ModelCategoriaProducto::all();
        $unidades = ModelUnidadMedida::all();

        return view('livewire.inventario.producto',  compact("categorias","unidades"));
    }
}
