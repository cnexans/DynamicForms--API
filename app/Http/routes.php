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

/* ============================
=         Oauth Binding       =
============================== */

App::singleton('oauth2', function() {
	
	$storage = new App\Helpers\OAuthPdo
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

/*=====  Oauth Binding  ======*/



/*====================================
=            Oauth Routes            =
====================================*/

Route::post('oauth/token', 'OAuthController@getAccessToken');

Route::get('oauth/token', function(){
	return response()->json([
		'error' => 'Bad request',
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

/*=====     Oauth Routes     ======*/



// Mostrar lista de los recursos
Route::any('/', function() {
	return response()->json([
		'resources' => [
			// oauth resources
			'oauth/token' => 'creates or refreshes an oauth token. Make a get request for more info',

			// form resources
			'form/new'        => 'creates a new form, fields structure pending',
			'form/add-fields' => 'add structures to existing form',
			'form/structure'  => 'gives the structure fields of an existing form',

			// user resources
			'user/new-employee'     => 'creates a new user with role employee',
			'user/new-manager'      => 'creates a new user with role manager',
			'user/list-all'         => 'gives a list of all users',
			'user/list-with-role'   => 'gives a list of all users given an specific role',
			'user/remove'           => 'delete a user',
			'user/attach/{form_id}' => 'give a user, normally an employee, the permission of answer a form',
			'user/detach/{form_id}' => 'quits a user, normally an employee, the permission of answer a form',
		]
	], 200);
});

// Skel para rutas con prefijo
Route::group(['prefix' => 'form'], function ()
{
	Route::post('new', [
		'uses' => 'DashboardController@create'
	]);


	Route::post('add-fields', [
		'uses' => 'DashboardController@addFields'
	]);

	Route::post('structure', [
		'uses' => 'DashboardController@structure'
	]);

    //Route::post('add_fields', ['uses' => 'FormController@add_fields']);
    //
});

Route::group(['prefix' => 'user'], function ()
{
	Route::post('new-employee', [
		'uses' => 'UserController@newEmployee'
	]);

	Route::post('new-manager', [
		'uses' => 'UserController@newManager'
	]);

	Route::post('list-all', [
		'uses' => 'UserController@listAll'
	]);

	Route::post('list-with-role', [
		'uses' => 'UserController@listWithRole'
	]);

	Route::post('remove', [
		'uses' => 'UserController@remove'
	]);

	Route::post('attach/{user_id}', [
		'uses' => 'UserController@attachUserToForm'
	]);

	Route::post('detach/{user_id}', [
		'uses' => 'UserController@detachUserToForm'
	]);

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