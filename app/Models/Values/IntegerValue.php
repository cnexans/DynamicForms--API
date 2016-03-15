<?php

namespace App\Models\Values;

use Illuminate\Database\Eloquent\Model;

class IntegerValue extends Model
{
	use ValueTrait;

	protected $table = 'integer_values';

	public function __construct()
	{
		parent::__construct();

		$this->value_type = 'integer';
	}
}
