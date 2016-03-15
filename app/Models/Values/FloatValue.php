<?php

namespace App\Models\Values;

use Illuminate\Database\Eloquent\Model;

class FloatValue extends Model
{
	use ValueTrait;

	protected $table = 'float_values';

	public function __construct()
	{
		parent::__construct();

		$this->value_type = 'float';
	}  
}
