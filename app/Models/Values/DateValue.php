<?php

namespace App\Models\Values;

use Illuminate\Database\Eloquent\Model;

class DateValue extends Model
{
	use ValueTrait;

	protected $table = 'date_values';

	public $timestamps = false;

	protected $fillable = ['field_descriptor_id', 'form_answer_id', 'value'];

	public function __construct()
	{
		parent::__construct();

		$this->value_type = 'date';
	}  
}
