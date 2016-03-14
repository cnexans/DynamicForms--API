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
            //Identificador
            $table->increments('id'); 

            //Valor
            $table->float('value'); 


            //Referencia al campo al cual pertenece
            $table->integer('field_descriptor_id')->unsigned();
            $table->foreign('field_descriptor_id')->references('id')->on('field_descriptors');


            //Referencia a la instancia del campo al cual pertenece
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
