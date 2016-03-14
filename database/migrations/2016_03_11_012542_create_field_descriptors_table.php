<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldDescriptorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Campos que pertenecen a un tipo de formulario
        Schema::create('field_descriptors', function (Blueprint $table) {
            $table->increments('id');
            //Formulario al cual pertece
            $table->integer('form_id')->unsigned(); 
            $table->foreign('form_id')->references('id')->on('forms');

            //Posicion dentro del render
            $table->integer('position');

            // Etiqueta de muestra para el campo
            $table->text('label');

            // Pregunta para el campo
            $table->text('question');

            // Tipo de campo/tabla a utilizar
            $table->enum('type',
                ['TEXT',           // area de texto          --> text_values
                'STRING',          // campo de texto         --> string_values
                'NUMBER',          // campo de numero        --> float_values
                'DATE',            // campo de fecha         --> date_values
                'RATING',          // campo de rating        --> integer_values
                'LOCATION',        // campo de GPS           --> location_values
                'PHOTO',           // capturar foto          --> blob_values
                'CANVAS_PHOTO',    // capturar y editar foto --> blob_values
                'OPTION',          // seleccionar opcion     --> integer_values
                                   // opciones posibles      --> option_types
                'QR_CODE'          // leer codigo QR         --> text_values
                ]);


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
        Schema::dropIfExists('option_types');

        Schema::dropIfExists('location_values');
        Schema::dropIfExists('float_values');
        Schema::dropIfExists('integer_values');
        Schema::dropIfExists('blob_values');
        Schema::dropIfExists('text_values');
        Schema::dropIfExists('string_values');
        Schema::dropIfExists('date_values');


        Schema::drop('field_descriptors');
    }
}
