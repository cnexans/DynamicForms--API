<?php

namespace App\Models\Values;

use Illuminate\Database\Eloquent\Model;

class LocationValue extends Model
{
	use ValueTrait;

	protected $table = 'location_values';

	public $timestamps = false;

	protected $fillable = ['field_descriptor_id', 'form_answer_id', 'lat_value', 'lng_value'];

	public function __construct()
	{
		parent::__construct();

		$this->value_type = 'location';
	}  
}
