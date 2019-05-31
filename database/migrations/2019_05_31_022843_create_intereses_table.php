<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInteresesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intereses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("id_persona");
            $table->unsignedBigInteger("id_carrera");
            $table->unsignedBigInteger("id_origen");
            $table->unsignedBigInteger("id_usuario_creador");
            $table->unsignedBigInteger("id_usuario_editor")->nullable();
            $table->timestamps();
        });

        Schema::table("intereses", function(Blueprint $table){

            $table->foreign("id_persona")
                ->references("id")
                ->on("personas");

            $table->foreign("id_carrera")
                ->references("id")
                ->on("carreras");

            $table->foreign("id_origen")
                ->references("id")
                ->on("origenes");

            $table->foreign("id_usuario_creador")
                ->references("id")
                ->on("users");

            $table->foreign("id_usuario_editor")
                ->references("id")
                ->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intereses');
    }
}
