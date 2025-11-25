<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'proveedor_id',
        'user_id',
        'nombre_contacto',
        'correo_contacto',
        'estado',
    ];

    // Relación con proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relación con usuario común
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
