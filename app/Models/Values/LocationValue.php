<?php

namespace App\Models\Values;

use Illuminate\Database\Eloquent\Model;

class LocationValue extends Model
{
	use ValueTrait;

	protected $table = 'location_values';

	public $timestamps = false;

	public function __construct()
	{
		parent::__construct();

		$this->value_type = 'location';
	}  
}
