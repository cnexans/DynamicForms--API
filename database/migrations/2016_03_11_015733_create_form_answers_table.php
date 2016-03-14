<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Respuesta a un cierto campo de una cierta instancia de formulario
        Schema::create('form_answers', function (Blueprint $table) {
            $table->increments('id');

            //Instancia de formulario a la cual pertenece
            $table->integer('form_instance_id')->unsigned();

            //Id del valor donde buscar la respuesta al campo
            $table->integer('data_row')->unsigned();

            //Ccampo al cual pertenece
            $table->integer('field_descriptor_id')->unsigned();
            $table->foreign('field_descriptor_id')->references('id')->on('field_descriptors');

            //Referencia a la instancia de formulario
            $table->foreign('form_instance_id')->references('id')->on('form_instances');
            
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
        Schema::dropIfExists('location_values');
        Schema::dropIfExists('float_values');
        Schema::dropIfExists('integer_values');
        Schema::dropIfExists('blob_values');
        Schema::dropIfExists('text_values');
        Schema::dropIfExists('string_values');
        Schema::dropIfExists('date_values');


        Schema::drop('form_answers');
    }
}
