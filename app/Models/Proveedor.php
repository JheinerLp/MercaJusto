<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'empresa',
        'user_id',
        'categoria_id',
        'sede_id',
        'ubicacion',
        'descripcion',
        'foto',
        'banner',
        'whatsapp',
        'foto_public_id',
        'banner_public_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class)
            ->select('id', 'nombre', 'precio', 'foto', 'proveedor_id', 'categoria_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accesores opcionales para nombre y correo directamente
    public function getNombreDueñoAttribute()
    {
        return $this->user ? $this->user->name : null;
    }

    public function getCorreoDueñoAttribute()
    {
        return $this->user ? $this->user->email : null;
    }
}
