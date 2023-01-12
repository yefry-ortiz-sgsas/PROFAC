<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelNotaCredito extends Model
{
    use HasFactory;
    protected $table = 'nota_credito';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'numero_nota',
        'cai',
        'numero_secuencia_cai',
        'fecha',
        'sub_total',
        'isv',
        'total',
        'factura_id',
        'cai_id',
        'motivo_nota_credito_id',
        'users_id',
        'estado_nota_id'
    ];
}
