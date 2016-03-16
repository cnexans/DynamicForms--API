<?php

namespace App\Models\Values;

use Illuminate\Database\Eloquent\Model;

class DateValue extends Model
{
	use ValueTrait;

	protected $table = 'date_values';

	public $timestamps = false;

	public function __construct()
	{
		parent::__construct();

		$this->value_type = 'date';
	}  
}
