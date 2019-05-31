<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLlamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('llamadas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("id_interesado");
            $table->unsignedBigInteger("id_usuario_llamada");
            $table->unsignedBigInteger("orden");
            $table->time("inicio_llamada");
            $table->time("fin_llamada");
            $table->date("fecha_llamada");
            $table->enum("respuesta", ["SI", "NO", "MAS TARDE"]);
            $table->boolean("ultima_llamada")->default(true);
            $table->unsignedBigInteger("id_usuario_creador");
            $table->unsignedBigInteger("id_usuario_editor")->nullable();
            $table->timestamps();
        });

        Schema::table("llamadas", function(Blueprint $table){

            $table->foreign("id_interesado")
                ->references("id")
                ->on("intereses");

            $table->foreign("id_usuario_llamada")
                ->references("id")
                ->on("users");

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
        Schema::dropIfExists('llamadas');
    }
}
