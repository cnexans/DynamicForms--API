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
use App\Models\FormInstance as FormInstance;
use App\Models\FormAnswer as FormAnswer;
use App\Models\Values\BlobValue as BlobValue;
use Image;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth');
        $this->middleware('admin');
    }
    /**
     * Insertar una nueva tabla de formulario vacía
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Revisar que usuario y agregarlo en el insert

        $form = Form::create([
            'user_id' => $request->input('user_id'),
            'name'    => $request->input('name', 'Untitled')
        ]);

        return response()->json([
            'success' => true,
            'form_id' => $form->id
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addFields(Request $request)
    {
        if ( !$request->has('id') ):
            return response()->json([
                'success' => false,
                'error'   => 402,
                'message' => 'id field not found'
            ], 402);
        endif;


        $form_id = $request->input('id');
        $fields  = collect( json_decode($request->input('form_structure')) );

        $fields->each(function($field)
        {
            $saved = Descriptor::create([
                'form_id'  => RequestFacade::input('id'),
                'position' => $field->position,
                'label'    => $field->label,
                'question' => $field->question,
                'type'     => $field->type
            ]);

            if ( $field->type == 'OPTION' ):

                foreach ( $field->options as $option_type ):
                    OptionType::create([
                        'field_descriptor_id' => $saved->id,
                        'display_option'      => $option_type->display_name
                    ]);
                endforeach;

            endif;
        });

        return response()->json([
            'success' => true
        ], 200);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function structure(Request $request)
    {
        if ( !$request->has('form_id') ):
            return response()->json([
                'success' => false,
                'error'   => 401,
                'message' => 'form_id field not found'
            ], 401);
        endif;


        // Una coleccion de objetos
        $fields = Form::find($request->input('form_id'))->getFieldDescriptors()->toArray();

        foreach( $fields as $k => $field ):

            if ( $field['type'] == 'OPTION' )
                $fields[$k]['options'] = OptionType::fromDescriptor( $field['id'] )->toArray();

        endforeach;

        return response()->json($fields, 200);


    }


    public function formList()
    {

        return response()->json(Form::all(), 200);
    }

    public function deleteForm(Request $request)
    {
        if ( !$request->has('form_id') )
            return response()->json([
                'success' => false,
                'error'   => '402',
                'message' => 'form_id field not found in the request'
            ], 402);

        if ( ($form = Form::find($request->input('form_id'))) != null )
            $form->delete();

        return response()->json([
            'success' => true
        ], 200);
    }

    public function answersByFormId(Request $request)
    {
        if ( !$request->has('form_id') )
            return response()->json([
                'success' => false,
                'error'   => '402',
                'message' => 'form_id field not found in the request'
            ], 402);


        if ( !( $form = Form::find($request->input('form_id')) ) )
            return response()->json([
                'success' => false,
                'error'   => '402',
                'message' => 'The form does not exist'
            ], 402);


        $instances = $form->getFormInstances()->map(function($instance) {
            $response = new \StdClass();

            $response->id          = $instance->id;
            $response->created_at  = $instance->created_at->toW3cString();;
            $response->answered_by = User::withTrashed()->find( $instance->user_id );

            return $response;
        });


        return response()->json($instances, 200);


    }


    public function getInstanceAnswers(Request $request)
    {
        if ( !$request->has('form_instance_id') )
            return response()->json([
                'success' => false,
                'error'   => '402',
                'message' => 'form_instance_id field not found in the request'
            ], 402);


        $answers = FormAnswer::where('form_instance_id', $request->input('form_instance_id'))->get();

        $answers = $answers->map(function($answer) {
            $response = new \StdClass();

            $response->descriptor = $answer->getDescriptor();
            $value_ref            = $answer->getValue();
            //$response->value      = $answer->getValue();

            

            if ( $response->descriptor->type == 'PHOTO' ||  $response->descriptor->type == 'CANVAS_PHOTO' ):

                $response->value = url('/images/' . $answer->data_row);

            elseif ( $response->descriptor->type == 'OPTION' ):

                $response->value = OptionType::find( $value_ref->value )->display_option;

            elseif ( $response->descriptor->type == 'LOCATION' ):

                $response->value =  new \StdClass();
                $response->value->lat = $value_ref->lat_value;
                $response->value->lng = $value_ref->lng_value;

            else:

                $response->value = $value_ref->value;

            endif;

            return $response;
        });


        return response()->json($answers, 200);
    }

    public function showImage(Request $request, $id)
    {
        $photo = BlobValue::find($id);
        if ( $photo == null )
        {
            return response()->json([
                'error' => 1,
                'message' => 'Archivo no encontrado'
            ]);
        }
        $response = response()->make( $photo->value, 200 );
        $response->header('Content-Type', $photo->mime_type);

        return $response;
    }

}
