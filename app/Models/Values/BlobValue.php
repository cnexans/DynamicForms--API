<?php

namespace App\Models\Values;

use Illuminate\Database\Eloquent\Model;

class BlobValue extends Model
{
	use ValueTrait;

	protected $table = 'blob_values';

	public function __construct()
	{
		parent::__construct();

		$this->value_type = 'blob';
	}  
}
