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
    public function add_fields(Request $r){
        print $r["id"];
        foreach ($r["fields"] as $value) {
            print $value;
        }
        return response()-> json(['id' => "holi"]);
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
