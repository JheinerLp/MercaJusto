<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudProveedor extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_proveedor';

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'descripcion',
        'motivo_rechazo',
        'nombre_empresa',
        'direccion',
        'categoria_id',
        'sede_id',
        'estado',
        'respuesta_admin',

    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeAceptadas($query)
    {
        return $query->where('estado', 'aprobado');
    }

    public function scopeRechazadas($query)
    {
        return $query->where('estado', 'rechazado');
    }
}
