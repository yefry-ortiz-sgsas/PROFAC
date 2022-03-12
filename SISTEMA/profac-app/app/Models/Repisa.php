<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repisa extends Model
{
    use HasFactory;
    protected $table = 'repisa';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'id_estante' ,'nombre'];
}
