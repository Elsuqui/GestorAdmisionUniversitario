<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoOrigenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_origenes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("descripcion");
            $table->boolean("estado")->default(true);
            $table->unsignedBigInteger("id_usuario_creador");
            $table->unsignedBigInteger("id_usuario_editor")->nullable();
            $table->timestamps();
        });

        Schema::table("tipo_origenes", function(Blueprint $table){

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
        Schema::dropIfExists('tipo_origenes');
    }
}
