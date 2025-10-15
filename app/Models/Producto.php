<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    public function scopeActivos($query)
    {
        return $query->where('estado_producto', 'activo');
    }
}
