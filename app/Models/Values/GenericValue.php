<?php

namespace App\Models\Values;

class GenericValue
{
	private $field_descriptor;
	private $form_answer;
	private $value;
	private $model;

	/*==================================================
	=            Basic Setters of the Value            =
	==================================================*/
	
	public function setFieldDescriptor( $id )
	{
		$this->field_descriptor = $id;
	}

	public function setFormAnswer( $id )
	{
		$this->form_answer = $id;
	}

	public function setValue( $val )
	{
		$this->value = $val;
	}

	public function isValid()
	{
		return (!is_null($this->field_descriptor) &&
			!is_null($this->form_answer) &&
			!is_null($this->model) &&
			!is_null($this->value) );
	}

	public function setModel( $class )
	{
		$this->model = $class;
	}
	
	/*=====  End of Basic Setters of the Value  ======*/

	/*========================================================
	=            Saves to the correct value Model            =
	========================================================*/
	
	public function save()
	{
		// Si esta instancia no es valida retorna null
		if ( !$this->isValid() )
			return null;

		// Se crea una instancia del modelo pedido
		$ref = new $this->model;


		// Se guarda el id de field_descriptor y form_answer asociado
		$ref->field_descriptor_id = $this->field_descriptor;
		$ref->form_answer_id      = $this->form_answer;


		// Se formatean los datos dependiendo del caso del Modelo
		if ( $this->model == \App\Models\Values\LocationValue::class )
		{
			$ref->lat_value           = $this->value['lat'];
			$ref->lng_value           = $this->value['lng'];
		}
		else if ( $this->model == \App\Models\Values\BlobValue::class )
		{
			$ref->value     = $this->value['binary'];
			$ref->mime_type = $this->value['mime_type'];
		}
		else
		{
			$ref->value = $this->value;
		}


		// Se guarda en la base de datos
		$ref->save();

		// Se retorna la instancia
		return $ref;
	}
	
	/*=====  End of Saves to the correct value Model  ======*/


}
