<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'session_token',
        'estado',
        'total_items',
        'total',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CarritoItem::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function scopeActivo($query)
    {
        return $query->where('estado', 'abierto');
    }
}
