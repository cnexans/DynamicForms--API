<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth');
    }
    /**
     * Insertar una nueva tabla de formulario vacía
     *
     * @return \Illuminate\Http\Response
     */
    public function make_new(Request $request){
        // Revisar que usuario y agregarlo en el insert

        if (User::is_admin($request->input('user_id'))) {
            $id = DB::table('forms')->insertGetId(
                ['user_id' => $request->input('user_id')]
            );
            return response()->json(['form_id' => $id]);
        } else {
            return response()->json(['not_authorized'=> "Not an admin user." ], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_fields(Request $request){
        $json = (array) json_decode($request["form_structure"],true);

        // Verificar que el usuario concuerda con el del form
        // Verificar que tiene los permisos adecuados
        // Verificar que no tiene campos ya

        foreach ($json['fields'] as $field)
        {
            // echo gettype($field['position']) . "";
            // echo gettype($field['label']) . "";
            // echo gettype($field['question']) . "";
            // echo gettype($field['type']) . "";

            // Revisar que todos los tipos concuerdan o hacer
            // insert en un batch

            DB::table('field_descriptors')->insert([
                    // 'id'       => $acum + $j,
                    'form_id'  => $json['id'],
                    'position' => $field['position'],
                    'label'    => $field['label'],
                    'question' => $field['question'],
                    'type'     => $field['type']
                    ]);
        };

        return response()-> json(['status' => "holi"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function structure(){

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
