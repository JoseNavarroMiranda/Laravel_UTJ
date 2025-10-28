<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $with = ['imagenes'];

    public function scopeActivos($query)
    {
        return $query->where('estado_producto', 'activo');
    }

    public function imagenes()
    {
        return $this->hasMany(ProductoImagen::class);
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(ProductoImagen::class)->oldestOfMany();
    }
}
