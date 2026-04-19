<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotes extends Model
{
    /** @use HasFactory<\Database\Factories\LotesFactory> */
    use HasFactory;

    
    protected $fillable = [
       'descripción', 'producto_id', 'cantidad', 'almacen_id', 'estado', 'usuario', 'habilitado', 'eliminado',
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
