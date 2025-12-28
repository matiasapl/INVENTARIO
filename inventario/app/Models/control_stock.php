<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class control_stock extends Model
{

    protected $fillable = [
        'codigo', 'nombre', 'stock_previo', 'stock_actual', 'usuario'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario');
    }
    /** @use HasFactory<\Database\Factories\ControlStockFactory> */
    use HasFactory;
}
