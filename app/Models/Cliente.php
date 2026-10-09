<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false;

    protected $fillable = [
        'codigo', 'nombre', 'nit', 'tipo', 'telefono',
        'vehiculo', 'ultima_visita', 'dias_credito', 'saldo_pendiente',
    ];
}