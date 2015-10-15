<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use \OAuth2\HttpFoundationBridge\Request as OAuth2_Request;
use \OAuth2\HttpFoundationBridge\Response as OAuth2_Response;

class OAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if ( !$request->input('access_token') )
            return response()->json(['error' => 'Token not found'], 422);

        $req = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

        $bridgeRequest = OAuth2_Request::createFromRequest($req);
        $bridgeResponse = new OAuth2_Response;

        if ( !$token = App::make('oauth2')->getAccessTokenData($bridgeRequest, $bridgeResponse) )
        {
            $response = App::make('oauth2')->getResponse();

            if( $response->isClientError() && $response->getParameter('error') )
            {
                if ( $response->getParameter('error') == 'expired_token' )
                    return response()->json(['error' => 'The access token provided has expired'], 401);
            }

            return response()->json(['error' => 'Invalid access token'], 422);
        }
        else
        {
            $request['user_id'] = $token['user_id'];
        }



        return $next($request);
    }




}
