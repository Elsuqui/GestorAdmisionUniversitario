<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOrigenesToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //Se agrega la relación con el usuario
            $table->unsignedBigInteger("id_origen")->nullable();
        });

        Schema::table("users", function (Blueprint $table){
            $table->foreign("id_origen")->references("id")->on("origenes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropForeign(["id_origen"]);
            $table->dropColumn("id_origen");
        });
    }
}
