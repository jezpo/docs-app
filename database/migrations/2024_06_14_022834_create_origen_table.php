<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('origen_tipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo', 10)->unique();
            $table->timestamps();
        });

        // Llenar la tabla con los valores estáticos
        DB::table('origen_tipos')->insert([
            ['tipo' => 'enviado'],
            ['tipo' => 'recibido']
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('origen_tipos');
    }
};
