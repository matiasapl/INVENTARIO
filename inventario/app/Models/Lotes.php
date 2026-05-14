<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotes extends Model
{
    /** @use HasFactory<\Database\Factories\LotesFactory> */
    use HasFactory;

    protected $fillable = [
       'descripcion', 'producto_id', 'cantidad', 'almacen_id', 'estado', 'usuario', 'habilitado', 'eliminado',
    ];

    /**
     * Castings para tipos de datos.
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

    public function producto()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
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
