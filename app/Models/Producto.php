<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'proveedor_id',
        'nombre',
        'descripcion',
        'precio',
        'foto',
        'categoria_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function sede()
{
    // Acceso indirecto a la sede a través del proveedor
    return $this->belongsToThrough(Sede::class, Proveedor::class);
    // Nota: belongsToThrough requiere paquete de terceros como "staudenmeir/eloquent-has-many-deep"
}

}
