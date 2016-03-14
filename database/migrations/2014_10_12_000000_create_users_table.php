<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            
            $table->increments('id');

            //Nombre del usuario
            $table->string('name');

            //Email unico del usuario
            $table->string('email')->unique();

            //Clave para hacer login
            $table->string('password', 60);

            //Rol dentro de la aplicacion
            $table->enum('membership',['employee','manager','president']);


            $table->timestamps();
            $table->rememberToken();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_instances');
        Schema::dropIfExists('forms');


        Schema::drop('users');
    }
}
