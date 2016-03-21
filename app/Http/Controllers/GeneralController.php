<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Models\Form;
use App\Models\FieldDescriptor as Descriptor;
use App\Models\OptionType as OptionType;
use App\Models\FormAnswer as Answer;
use App\Models\FormInstance as FormInstance;
use Image;
use Hash;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth');
    }

    public function me(Request $request)
    {
        return response()->json(User::find( $request->input('user_id') ), 200);
    }

    public function myEdit(Request $request)
    {
    	$user = User::find( $request->input('user_id') );

    	if ( $request->has('email') )
    		$user->email = $request->input('email');

    	if ( $request->has('password') )
    		$user->password = Hash::make($request->input('password'));

    	if ( $request->has('name') )
    		$user->name = $request->input('name');


    	$user->save();

    	return response()->json([
    		'success' => true
    	], 200);

    }

    public function insertAnswer(Request $request)
    {
        if ( !$request->has('form_instance_id') ):
            return response()->json([
                'success' => false,
                'error'   => 402,
                'message' => 'form_instance_id field not found'
            ], 402);
        endif;

        if ( !$request->has('field_descriptor_id') ):
            return response()->json([
                'success' => false,
                'error'   => 402,
                'message' => 'field_descriptor_id field not found'
            ], 402);
        endif;

        $descriptor = Descriptor::find( $request->input('field_descriptor_id') );

        //return response()->json($descriptor, 200);

        if ( $descriptor->type == 'PHOTO' || $descriptor->type == 'CANVAS_PHOTO'):

            if (!$request->hasFile('value') || !$request->file('value')->isValid()):
                return response()->json([
                    'error'   => 1,
                    'message' => 'There was an error uploading the photo to the server.'
                ]);
            endif;

            $image = Image::make( $request->value->getRealPath() )->interlace();
            $image->widen(400);

            $value = [
                'binary'    => $image->encode('jpg', 20),
                'mime_type' => $request->value->getMimeType()
            ];

        elseif( $descriptor->type == 'LOCATION' ) :

            if ( !$request->has('lat') || !$request->has('lng') ):
                return response()->json([
                    'success' => false,
                    'error'   => 402,
                    'message' => 'lat value or lng value not found in the request'
                ], 402);
            endif;

            $value = [
                'lat' => $request->input('lat'),
                'lng' => $request->input('lng'),
            ];

        else :
            if ( !$request->has('value') ):
                return response()->json([
                    'success' => false,
                    'error'   => 402,
                    'message' => 'value not found in the request'
                ], 402);
            endif;
            $value = $request->input('value');
        endif;

        $result = Answer::register(
            $descriptor->id,
            $request->input('form_instance_id'),
            $value
        );


        if ( !$result )
            return response()->json([
                'success' => false,
                'error'   => 500,
                'message' => 'There was an error... report to administrator'
            ], 500);

        return response()->json([
            'success' => true
        ], 200);

    }

    public function createFormInstance(Request $request)
    {
        if ( !$request->has('form_id') ):
            return response()->json([
                'success' => false,
                'error'   => 402,
                'message' => 'form_id field not found'
            ], 402);
        endif;

        $instance = FormInstance::create([
            'user_id' => $request->input('user_id'),
            'form_id' => $request->input('form_id')
        ]);

        return response()->json([
            'success'     => true,
            'instance_id' => $instance->id
        ], 200);

    }

}
