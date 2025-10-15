<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function scopeActivos($query)
    {
        return $query->Where('estado_producto', 'activo');
    }
}
