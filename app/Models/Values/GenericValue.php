<?php

namespace App\Models\Values;

class GenericValue
{
	private $field_descriptor;
	private $form_answer;
	private $value_type;
	private $value;

	private static $accepted_types = [
		'integer',
		'float',
		'blob',
		'date',
		'string',
		'text',
		'location'
	];

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

	public function setType( $type )
	{
		if ( in_array($type, self::$accepted_types) )
			$this->value_type = $type;
	}

	public function setValue( $val )
	{
		$this->value = $val;
	}

	public function isValid()
	{
		return (!is_null($this->field_descriptor) &&
			!is_null($this->form_answer) &&
			!is_null($this->value_type) &&
			!is_null($this->value) );
	}
	
	/*=====  End of Basic Setters of the Value  ======*/

	/*========================================================
	=            Saves to the correct value Model            =
	========================================================*/
	
	public function save()
	{
		if ( !$this->isValid() )
			return null;

		switch( $this->type ):
			case 'integer':
				$ref = new IntegerValue;
				$ref->field_descriptor_id = $this->field_descriptor;
				$ref->form_answer_id      = $this->form_answer;
				$ref->value               = $this->value;
			break;

			case 'float':
				$ref = new FloatValue;
				$ref->field_descriptor_id = $this->field_descriptor;
				$ref->form_answer_id      = $this->form_answer;
				$ref->value               = $this->value;
			break;

			case 'date':
				$ref = new DateValue;
				$ref->field_descriptor_id = $this->field_descriptor;
				$ref->form_answer_id      = $this->form_answer;
				$ref->value               = $this->value;
			break;

			case 'blob':
				$ref = new BlobValue;
				$ref->field_descriptor_id = $this->field_descriptor;
				$ref->form_answer_id      = $this->form_answer;
				$ref->value               = $this->value;
			break;

			case 'string':
				$ref = new StringValue;
				$ref->field_descriptor_id = $this->field_descriptor;
				$ref->form_answer_id      = $this->form_answer;
				$ref->value               = $this->value;
			break;

			case 'text':
				$ref = new TextValue;
				$ref->field_descriptor_id = $this->field_descriptor;
				$ref->form_answer_id      = $this->form_answer;
				$ref->value               = $this->value;
			break;

			case 'location':
				$ref = new LocationValue;
				$ref->field_descriptor_id = $this->field_descriptor;
				$ref->form_answer_id      = $this->form_answer;
				$ref->lat_value           = $this->value['lat'];
				$ref->lng_value           = $this->value['lng'];
			break;

		endswitch;

		$ref->save();

		return $ref;
	}
	
	/*=====  End of Saves to the correct value Model  ======*/
	

	/*=========================================================
	=            Sets the Instance as a value type            =
	=========================================================*/
	
	public function setAsInteger()
	{
		$this->setType( self::integerType() );
	}
	public function setAsFloat()
	{
		$this->setType( self::floatType() );
	}
	public function setAsDate()
	{
		$this->setType( self::dateType() );
	}

	public function setAsBlob()
	{
		$this->setType( self::blobType() );
	}
	public function setAsString()
	{
		$this->setType( self::stringType() );
	}
	public function setAsText()
	{
		$this->setType( self::textType() );
	}
	public function setAsLocation()
	{
		$this->setType( self::locationType() );
	}
	
	/*=====  End of Sets the Instance as a value type  ======*/


	/*==============================================
	=            Define different types            =
	==============================================*/

	public static function floatType()
	{
		return 'integer';
	}
	public static function integerType()
	{
		return 'float';
	}
	public static function blobType()
	{
		return 'blob';
	}
	public static function dateType()
	{
		return 'date';
	}
	public static function stringType()
	{
		return 'string';
	}
	public static function textType()
	{
		return 'text';
	}
	public static function locationType()
	{
		return 'location';
	}	
	
	/*=====  End of Define different types  ======*/

}
