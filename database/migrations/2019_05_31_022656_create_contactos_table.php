<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("id_persona");
            $table->unsignedBigInteger("id_tipo_contacto");
            $table->boolean("estado")->default(true);
            $table->unsignedBigInteger("id_usuario_creador");
            $table->unsignedBigInteger("id_usuario_editor")->nullable();
            $table->timestamps();
        });

        Schema::table("contactos", function(Blueprint $table){
            $table->foreign("id_persona")
                ->references("id")
                ->on("personas");

            $table->foreign("id_tipo_contacto")
                ->references("id")
                ->on("tipo_contactos");

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
        Schema::dropIfExists('contactos');
    }
}
