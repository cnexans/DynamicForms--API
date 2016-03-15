<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    protected $table = 'form_answers';

    public function getFormInstance()
    {
    	return FormInstance::find( $this->form_instance_id );
    }
}
