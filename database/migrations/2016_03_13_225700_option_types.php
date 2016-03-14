<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OptionTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_types', function (Blueprint $table) {
            // Increiblemente ineficiente, un entero por cada respuesta. Lo dejo? el form_answer es unico. Quitar id afectaria el orm?
            $table->increments('id'); 
            $table->string('display_option');
            $table->integer('field_descriptor_id')->unsigned();
            $table->foreign('field_descriptor_id')->references('id')->on('field_descriptors');
            // $table->unique('form_answer_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('option_types');
    }
}