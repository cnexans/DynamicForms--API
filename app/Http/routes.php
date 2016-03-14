<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

App::singleton('oauth2', function() {
	
	$storage = new App\Http\Controllers\OAuthPdo
	([
		'dsn' => 'mysql:dbname='.env('DB_DATABASE').';host=' . env('DB_HOST'),
		'username' => env('DB_USERNAME'),
		'password' => env('DB_PASSWORD')
	]);

	$server = new OAuth2\Server($storage);
	
	$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
	$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
	$server->addGrantType(new OAuth2\GrantType\RefreshToken($storage));

	return $server;
});


Route::post('/', 'PostController@index');


Route::post('oauth/token', 'OAuthController@getAccessToken');

Route::get('oauth/token', function(){
	return response()->json([
		'error' => 'Missing OAuth params',
		'expected' => [
			'post' => [
				'grant_type',
				'username',
				'password',
				'client_id',
				'client_secret'
			]
		]
	], 400);
});

// Skel para rutas con prefijo
Route::group(['prefix' => 'form'], function () {
    Route::post('new', array('uses' => 'FormController@make_new'));
    Route::post('add_fields',array('uses' => 'FormController@add_fields'));
    Route::post('structure',array('uses' => 'FormController@structure'));
});

/*
Route::get('private', function()
{
	$bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
	$bridgedResponse = new OAuth2\HttpFoundationBridge\Response();
	
	if (App::make('oauth2')->verifyResourceRequest($bridgedRequest, $bridgedResponse)) {
		
		$token = App::make('oauth2')->getAccessTokenData($bridgedRequest);
		
		return Response::json(array(
			'private' => 'stuff',
			'user_id' => $token['user_id'],
			'client'  => $token['client_id'],
			'expires' => $token['expires'],
		));
	}
	else {
		return Response::json(array(
			'error' => 'Unauthorized'
		), $bridgedResponse->getStatusCode());
	}
});*/