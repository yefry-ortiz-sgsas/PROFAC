<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proveedores extends Model
{
    use HasFactory;
    protected $table = 'proveedores';
    protected $primaryKey = 'id';
    protected $fillable = ['id',
        'codigo',
        'nombre',
        'direccion',
        'contacto',
        'telefono_1',
        'telefono_2',
        'correo_1',
        'correo_2',
        'rtn',
        'pais',
        'departamento',
        'municipio','giro', 'categoria','retencion'];

}
