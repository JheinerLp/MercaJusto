<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = 'sedes';

    protected $fillable = [
        'nombre',
        'ciudad',
        'direccion',
    ];

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class);
    }
}
