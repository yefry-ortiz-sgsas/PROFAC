<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cDolar extends Model
{
    use HasFactory;
    protected $table = 'cvDolar';
    protected $primaryKey = 'id';
    protected $fillable = [ 'valor', 'user_id'];
}
