<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'codigo', 'nombre', 'categoria', 'marca', 'presentacion',
        'precio', 'precio_costo', 'stock_minimo', 'stock_actual',
    ];

    public function estaEnStockBajo(): bool
    {
        return $this->stock_actual <= $this->stock_minimo;
    }

    public function calcularMargen(): float
    {
        return $this->precio - $this->precio_costo;
    }
} 