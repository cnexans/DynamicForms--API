<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloatValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('float_values', function (Blueprint $table) {
            // Increiblemente ineficiente, un entero por cada respuesta. Lo dejo? el form_answer es unico. Quitar id afectaria el orm?
            $table->increments('id'); 
            $table->float('value'); 
            $table->integer('field_descriptor_id')->unsigned();
            $table->foreign('field_descriptor_id')->references('id')->on('field_descriptors');

            $table->integer('form_answer_id')->unsigned();
            $table->foreign('form_answer_id')->references('id')->on('form_answers');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('float_values');
    }
}
