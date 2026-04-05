<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    
class Product extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'precio_unitario', 'M3_unitario', 'usuario', 'estado', 'habilitado', 'eliminado'
    ];


public function user()
{
    return $this->belongsTo(User::class, 'usuario');
}


public function deshabilitar()
{
    $this->habilitado = false;
    return $this->save();
}

public function habilitar()
{
    $this->habilitado = true;
    return $this->save();
}

public function eliminar()
{
    $this->eliminado = true;
    return $this->save();
}
}
