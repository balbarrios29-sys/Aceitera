<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimiento';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id', 'entidad_afectada', 'entidad_id', 'accion', 'descripcion', 'fecha_hora',
    ];

    public static function registrar(string $entidad, int $entidadId, string $accion, string $descripcion): self
    {
        return self::create([
            // TODO: reemplazar el 1 por Auth::id() cuando exista el login
            'usuario_id' => 1,
            'entidad_afectada' => $entidad,
            'entidad_id' => $entidadId,
            'accion' => $accion,
            'descripcion' => $descripcion,
            'fecha_hora' => now(),
        ]);
    }
}