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
                'error'   => 401,
                'message' => 'id field not found'
            ], 401);
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
                        'display_option'      => $option_type
                    ]);
                endforeach;

            endif;
        });

        return response()->json([
            'success'      => true
        ]);
        
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

        return response()->json($fields, 401);


    }


    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // *
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
     
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
