<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\tb_resumen;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_resumens', function (Blueprint $table) {
            $table->id();
            $table->string('programa_educativo', 450);
            $table->integer('acreditacion')->nullable()->default(0);
            $table->integer('capacitacion')->nullable()->default(0);
            $table->integer('certificacion_competencias')->nullable()->default(0);
            $table->integer('evento')->nullable()->default(0);
            $table->integer('investigacion')->nullable()->default(0);
            $table->integer('material_educativo')->nullable()->default(0);
            $table->integer('plan_estudios')->nullable()->default(0);
            $table->integer('proyecto')->nullable()->default(0);
            $table->integer('otro')->nullable()->default(0);
            $table->integer('total')->nullable()->default(0);
            $table->string('actividades_transversales')->nullable()->default(null);
            $table->string('persona_acargo')->nullable()->default('Sin asignar');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_resumens');
    }
};
