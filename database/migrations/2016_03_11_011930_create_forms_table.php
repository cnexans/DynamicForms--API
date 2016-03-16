<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            //El president o manager que creo el formulario
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('forms', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('field_descriptors');

        Schema::drop('forms');
    }
}
