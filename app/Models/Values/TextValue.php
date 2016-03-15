<?php

namespace App\Models\Values;

use Illuminate\Database\Eloquent\Model;

class TextValue extends Model
{
	use ValueTrait;

	public function __construct()
	{
		parent::__construct();

		$this->value_type = 'text';
	}

    protected $table = 'text_values';
}
