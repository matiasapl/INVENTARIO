<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    
class Product extends Model
{
    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'stock', 'precio_unitario', 'M3_unitario', 'usuario', 'habilitado', 'eliminado'
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

public function sumar($cantidad)
{
    $this->stock += $cantidad;
    return $this->save();
}

public function restar($cantidad)
{
    $this->stock -= $cantidad;
    return $this->save();
}
}
