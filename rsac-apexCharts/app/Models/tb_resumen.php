<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_resumen extends Model
{
    use HasFactory;
    // agregar fillable al modelo
    protected $fillable = [
        'programa_educativo',
        'acreditacion',
        'capacitacion',
        'certificacion_competencias',
        'evento',
        'investigacion',
        'material_educativo',
        'plan_estudios',
        'proyecto',
        'otro',
        'total',
        'actividades_transversales'
    ];
}
