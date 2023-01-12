<?php

namespace App\Models\NotaDebito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notaDebito extends Model
{
    use HasFactory;
    protected $table = 'notaDebito';
    protected $primaryKey = 'id';
    protected $fillable = ['factura_id', 'montoNotaDebito_id','monto_asignado', 'fechaEmision', 'motivoDescripcion', 'cai_ndebito','numeroCai', 'correlativoND', 'estado_id','users_registra_id'];
}
