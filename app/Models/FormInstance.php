<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User as User;

class FormInstance extends Model
{
    protected $table = "form_instances";

    protected $fillable = ['user_id', 'form_id'];

    public function getFormClass()
    {
    	return Form::find( $this->form_id );
    }

    public function whoAnswered()
    {
    	return User::find( $this->user_id );
    }
}
