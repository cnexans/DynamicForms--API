<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LocationValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_values', function (Blueprint $table) {
            //Identificador
            $table->increments('id'); 

            //Valores de longitud y latitud
            $table->float('lat_value'); 
            $table->float('lng_value'); 


            //Referencia al campo al cual pertenece
            $table->integer('field_descriptor_id')->unsigned();
            $table->foreign('field_descriptor_id')->references('id')->on('field_descriptors');
            

            //Referencia a la instancia de campo al cual le da respuesta
            $table->integer('form_answer_id')->unsigned();
            $table->foreign('form_answer_id')->references('id')->on('form_answers');

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
        Schema::drop('location_values');
    }
}
