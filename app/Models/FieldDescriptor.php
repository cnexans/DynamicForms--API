<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldDescriptor extends Model
{
    protected $table = 'field_descriptors';


    public function getOwnerForm()
    {
    	return Form::find( $this->form_id );
    }

    public function getAllAnswers()
    {
    	return FormAnswer::where('form_instance_id', $this->id)
    		->get();
    }

    public static function valueClass( $type )
    {
        switch( $type ):

            case 'TEXT':
                return \App\Models\Values\TextValue::class;
            break;

            case 'STRING':
                return \App\Models\Values\StringValue::class;
            break;

            case 'NUMBER':
                return \App\Models\Values\FloatValue::class;
            break;

            case 'DATE':
                return \App\Models\Values\DateValue::class;
            break;

            case 'RATING':
                return \App\Models\Values\IntegerValue::class;
            break;

            case 'LOCATION':
                return \App\Models\Values\LocationValue::class;
            break;

            case 'PHOTO':
                return \App\Models\Values\BlobValue::class;
            break;

            case 'CANVAS_PHOTO':
                return \App\Models\Values\BlobValue::class;
            break;

            case 'OPTION':
                return \App\Models\Values\IntegerValue::class;
            break;

            case 'QR_CODE':
                return \App\Models\Values\TextValue::class;
            break;

        endswitch;
    }


    public function getValueClass()
    {
        return self::valueClass( $this->type );
    }
}
