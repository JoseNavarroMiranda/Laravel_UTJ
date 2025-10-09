<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function scopeActivos($query)
    {
    return $query-> Where('estado_categoria', 'activo');
    }   
}
