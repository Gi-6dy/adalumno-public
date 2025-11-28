<?php

namespace App\Models;

use App\Enums\Carrera;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'correo',
        'fecha_nacimiento',
        'sexo',
        'carrera',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'carrera' => Carrera::class,
    ];

    public function secciones()
    {
        return $this->belongsToMany(Seccion::class)->withTimestamps();
    }
}
