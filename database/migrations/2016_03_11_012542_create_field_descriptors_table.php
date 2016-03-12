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
        Schema::create('field_descriptors', function (Blueprint $table) {
            $table->increments('id');
            //Formulario al cual pertece
            $table->integer('form_id')->unsigned(); 
            $table->integer('number');   // N'umero de campo
            $table->integer('position'); // Posici'on
            $table->text('label');       // Etiqueta de muestra para el campo
            $table->text('question');    // Pregunta para el campo
            $table->enum('type',         // Tipo de campo/tabla a utilizar
                ['TEXT',
                 'INT',
                 'FLOAT',
                 'TIMESTAMP',
                 'RATING',   // TINYINT
                 'PICTURE',  // No encontre tipo adecuado para archivos en la documentacion de laravel
                 'LOCATION', // Tabla compuesta con dos float
                 ]);
            $table->softDeletes();
        });

        Schema::table('field_descriptors', function ($table) {
            $table->foreign('form_id')->references('id')->on('forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('field_descriptors');
    }
}
