<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('action');
            $table->text('details')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Índices para facilitar las consultas
            $table->index('model_type');
            $table->index('model_id');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
