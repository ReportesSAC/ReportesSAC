<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\tb_automotriz;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_automotrizs', function (Blueprint $table) {
            $table->id();
            $table->string('programa_educativo', 450);
            $table->string('proyecto_actividad', 450)->default('Sin proyecto');
            $table->string('descripcion', 600);
            $table->string('beneficios_impacto', 600);
            $table->string('responsable',450)->nullable()->defautl('sin responsable');
            $table->string('involucrados',450)->nullable()->defautl('sin involucrados');
            $table->string('PDI', 450);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('cantidad');
            // siempre seran 2 registros de unidad, si solo ocupa estudiantes solo rellana uno y el segundo lo pone como 'no aplica' y deja en 0 la cantidad
            $table->enum('unidad', ['Asignatura', 'Convenio', 'Docentes','Empresas', 'Estudiantes','Programa','Proyecto','Publicaciones','Reglamento', 'Otro','No aplica']);
            $table->integer('hombres1')->default(0);
            $table->integer('mujeres1')->default(0);
            $table->enum('unidad2', ['Asignatura', 'Convenio', 'Docentes','Empresas', 'Estudiantes','Programa','Proyecto','Publicaciones','Reglamento', 'Otro','No aplica']);
            $table->integer('hombres2')->default(0);
            $table->integer('mujeres2')->default(0);
            $table->enum('estatus', ['En proceso', 'Concluido', 'Cancelado']);
            $table->enum('categoria', ['Acreditación', 'Capacitación', 'Certificación-Competencias', 'Evento', 'Investigación', 'Material educativo', 'Plan de estudio', 'Proyecto', 'Otro']);
            $table->string('especificar', 450)->nullable()->default('Sin especificar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations. 
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_automotrizs');
    }
};
