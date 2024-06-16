<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gestion', function (Blueprint $table) {
            $table->id();
            $table->year('anio'); // Almacena el año
            $table->text('descripcion'); // Descripción del año de gestión
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gestion');
    }
};
