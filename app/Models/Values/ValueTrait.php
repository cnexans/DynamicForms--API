<?php

namespace App\Models\Values;
use App\Models\FormAnswer as FormAnswer;
use App\Models\FieldDescriptor as FieldDescriptor;

trait ValueTrait 
{

	public $value_type;

	public function getDescriptor()
	{
		return FieldDescriptor::find( $this->field_descriptor_id );
	}
	public function getFormOwner()
	{
		return FieldDescriptor::find( $this->field_descriptor_id )
			->getOwnerForm();
	}
	public function getWhoAnswered()
	{
		return FormAnswer::find( $this->form_answer_id )
			->getFormInstance()
			->whoAnswered();
	}
}