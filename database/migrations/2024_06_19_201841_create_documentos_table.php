<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('cite');
            $table->text('descripcion');
            $table->string('estado');
            $table->string('hash', 32);
            $table->integer('id_tipo_documento');
            $table->binary('documento');
            $table->string('id_programa', 5);
            $table->unsignedBigInteger('origen_tipos_id'); // Agregar columna para la clave foránea
            $table->timestamps();

            // Definir la clave foránea para origen_tipos_id
            $table->foreign('origen_tipos_id')->references('id')->on('origen_tipos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos');
    }
};
