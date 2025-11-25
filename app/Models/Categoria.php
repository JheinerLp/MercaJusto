<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'slug',
    ];

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class);
    }
}
