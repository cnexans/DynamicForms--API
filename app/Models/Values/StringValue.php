<?php

namespace App\Models\Values;

use Illuminate\Database\Eloquent\Model;

class StringValue extends Model
{
	use ValueTrait;

	protected $table = 'string_values';

	public function __construct()
	{
		parent::__construct();

		$this->value_type = 'string';
	}  
}
