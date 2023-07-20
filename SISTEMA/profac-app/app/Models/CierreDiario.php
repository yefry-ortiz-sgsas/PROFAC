<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CierreDiario extends Model
{
    use HasFactory;
    protected $table = 'cierrecaja';
    protected $primaryKey = 'id';
    protected $fillable = ['user_cierre_id', 'estado_cierre','fecha', 'factura','cliente','vendedor','subtotal','imp_venta','total','tipo','tipoFactura'];
}
