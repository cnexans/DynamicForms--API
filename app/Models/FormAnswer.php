<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Values\GenericValue as Value;

class FormAnswer extends Model
{
    protected $table = 'form_answers';

    protected $fillable = ['field_descriptor_id', 'form_instance_id', 'data_row'];

    // Esta es una respuesta a un campo de una cierta instancia de formulario
    public function getFormInstance()
    {
    	// Se retorna la instancia
    	return FormInstance::find( $this->form_instance_id );
    }

	public function getDescriptor()
	{
		// Se retorna el descriptor de este campo
		return FieldDescriptor::find( $this->field_descriptor_id );
	}



	// Obtiene el valor de esta respuesta
	public function getValue()
	{
		// Obtiene la clase a traves del metodo getValueClass de FieldDescriptor
		$class = $this->getDescriptor()->getValueClass();

		// Se retorna la instancia del modelo correcto
		return $class::find( $this->data_row );
	}


    public static function register($descriptor, $instance, $value)
    {
    	// Crea una nueva instancia de esta clase
    	$answer = new static();

    	// Si $descriptor es una instancia del modelo FieldDescriptor
    	if ( is_a($descriptor, 'App\Models\FieldDescriptor') )
    		// El id del FieldDescriptor esta en la instancia
    		$answer->field_descriptor_id = $descriptor->id;
    	else
    		// Sino, asume que $descriptor es la id
    		$answer->field_descriptor_id = $descriptor;

    	// Si $instance es una instancia de FormInstance
    	if ( is_a($instance, 'App\Models\FormInstance') )
    		// El id es $instance->id
    		$answer->form_instance_id = $instance->id;
    	else
    		// De lo contrario se asume que $instancia es la id de la instancia de formulario
    		$answer->form_instance_id = $instance;


    	// Se guarda esto en la base de datos y se obtiene el id del FormAnswer
    	$answer->save();


    	// Se crea una nueva instancia de Valor Generico
    	$ref = new Value();

    	// Se identifica el descriptor asociado
    	$ref->setFieldDescriptor( $answer->field_descriptor_id );

    	// Se identifica la id del FormAnswer
    	$ref->setFormAnswer( $answer->id );

    	// Se da el modelo al Valor generico, esto es manejado por el descriptor
    	$ref->setModel( $answer->getDescriptor()->getValueClass() );

    	// Se le da el valor
    	$ref->setValue($value);

    	// La clase valor generico tiene la responsabilidad de formatear el valor como se deba
    	$answer->data_row = $ref->save()->id;

    	// Se guarda la respuesta en la base de datos
    	$answer->save();

    	// Se retorna la instancia de FormAsnwer
    	return $answer;
    }
}
