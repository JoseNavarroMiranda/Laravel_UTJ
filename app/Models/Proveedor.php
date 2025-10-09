<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    // Scope para filtrar solo proveedores activos
    public function scopeActivos($query)
    {
        return $query->where('estado_proveedor', 'activo');
    }
}
