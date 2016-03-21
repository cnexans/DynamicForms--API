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

class OpenController extends Controller
{
    public function __construct()
    {
        /* ** */
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
