<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seccion extends Model
{
    use HasFactory;

    protected $fillable = ['seccion', 'aula'];

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class)->withTimestamps();
    }

    public function getRouteKeyName()
    {
        return 'seccion';
    }
}
