<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelValeHasProducto extends Model
{
    use HasFactory;
    protected $table = 'vale_has_producto';
    protected $primaryKey = 'id';
    protected $fillable = ['vale_id', 'producto_id','precio', 'cantidad_inicial','cantidad_entregada', 'sub_total','isv', 'total'];
}
