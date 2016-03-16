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


class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('oauth');
    //     $this->middleware('admin');
    // }

    /**
     * Insertar un usuario de tipo empleado en el sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function newEmployee(Requests $request)
    {
        return response()->json("hola");
    }
    
    /**
     * Insertar un usuario de tipo manager en el sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function newManager(Requests $request)
    {
        return response()->json("hola");
    }
    
    /**
     * Listar todos los usuarios del sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function listAll(Requests $request)
    {
        return response()->json("User::all()");
    }
    
    /**
     * Listar todos los usuarios del sistema por rol
     *
     * @param rol: tipo del rol a buscar
     * @return \Illuminate\Http\Response
     */
    public function listWithRole(Requests $request)
    {
        if ( !$request->has('role') ){

            return response()->json([
                'success' => false,
                'error'   => 401,
                'message' => 'No role found'
            ], 401);
        }
        
        return response()->json(User::getAllWithRole($request->input('role')));
    }

    /**
     * Listar todos los usuarios del sistema por rol
     *
     * @param rol: tipo del rol a buscar
     * @return \Illuminate\Http\Response
     */
    public function myUsers(Requests $request)
    {
        return response()->json("hola");
    }
}
