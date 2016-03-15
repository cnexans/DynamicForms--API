<?php

namespace App\Models\Values;

use Illuminate\Database\Eloquent\Model;

class TextValue extends Model
{
	use ValueTrait;

	protected $table = 'text_values';

	public $timestamps = false;

	public function __construct()
	{
		parent::__construct();

		$this->value_type = 'text';
	}  
}
