<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    /** @use HasFactory<\Database\Factories\AlmacenFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'ubicacion', 'estado', 'habilitado', 'eliminado', 'usuario'
    ];

    /**
     * Castings para tipos de datos.
     * MariaDB devuelve tinyint como entero, se castea a boolean.
     */
    protected function casts(): array
    {
        return [
            'habilitado' => 'boolean',
            'eliminado' => 'boolean',
            'estado' => 'boolean',
        ];
    }

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
