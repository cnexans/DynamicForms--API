<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \OAuth2\HttpFoundationBridge\Request as OAuth2_Request;
use \OAuth2\HttpFoundationBridge\Response as OAuth2_Response;
use \App as App;

/**
 * Oauth Controller for Custom User table
 *
 *
 * 
 */


class OauthController extends Controller
{
    public function getAccessToken(Request $request)
    {

    	
        $bridgedRequest  = OAuth2_Request::createFromRequest($request->instance());

        $bridgedResponse = new OAuth2_Response();
        
        $bridgedResponse = 
        App::make('oauth2')->handleTokenRequest (
        	$bridgedRequest, 
        	$bridgedResponse
        );
        
        return $bridgedResponse;
    }
}
