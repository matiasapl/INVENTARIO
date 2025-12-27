<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    
class Product extends Model
{
    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'stock', 'precio_unitario', 'M3_unitario', 'usuario', 'habilitado'
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


}
