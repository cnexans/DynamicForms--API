<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionType extends Model
{
    protected $table = "option_types";

    protected $fillable = ['field_descriptor_id', 'display_option'];
    protected $hidden = ['created_at', 'updated_at', 'field_descriptor_id'];

    public static function fromDescriptor( $id )
    {
    	return self::where('field_descriptor_id', $id)
    		->get();
    }

}
