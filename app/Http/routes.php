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
			'form/instances'  => 'gives the instances for the form in form_id field',
			'form/delete'     => 'deletes the form with id form_id in the request',


			'form/instance/create'          => 'creates a form instance of the form with id form_id in the request',
			'form/instance/register-answer' => 'register a field answer of field_descriptor_id in the form_instance_id',

			'form/instance/answers' => 'gives all the values with its fields descriptor for an instance of form_instance_id',
			'images/{id}'           => 'returns the image value with its mime type for <img>, it needs the access_token or else it will return an error json',

			// user resources
			'user/new-employee'     => 'creates a new user with role employee',
			'user/new-manager'      => 'creates a new user with role manager',
			'user/list-all'         => 'gives a list of all users',
			'user/list-with-role'   => 'gives a list of all users given an specific role',
			'user/remove'           => 'delete a user',
			'user/attach/{user_id}' => 'give a user, normally an employee, the permission of answer a form',
			'user/detach/{user_id}' => 'quits a user, normally an employee, the permission of answer a form',
			'user/me'       => 'gives the logged user info',
			'user/forms'    => 'gives the forms for a user with id of post data requested_user_id',
			'forms/list'    => 'gives a list of all forms',
			'user/{id}/edit' => 'edits a user',
			'user/edit/me'  => 'edits the current user profile',


			// pendientes
			'user/{id}/profile' => 'gives the user info',
			
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

	Route::post('list', [
		'uses' => 'DashboardController@formList'
	]);

	Route::post('delete', [
		'uses' => 'DashboardController@deleteForm'
	]);

	Route::post('instances', [
		'uses' => 'DashboardController@answersByFormId'
	]);


	Route::post('instance/create', [
		'uses' => 'GeneralController@createFormInstance'
	]);

	Route::post('instance/register-answer', [
		'uses' => 'GeneralController@insertAnswer'
	]);

	Route::post('instance/answers', [
		'uses' => 'DashboardController@getInstanceAnswers'
	]);
    //Route::post('add_fields', ['uses' => 'FormController@add_fields']);
    //
});

Route::get('images/{id}', [
	'uses' => 'OpenController@showImage'
]);

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

	Route::post('me', [
		'uses' => 'GeneralController@me'
	]);

	Route::post('forms', [
		'uses' => 'UserController@attachedForms'
	]);

	Route::post('{id}/profile', [
		'uses' => 'UserController@userProfile'
	]);

	Route::post('/{id}/edit', [
		'uses' => 'UserController@editUser'
	]);

	Route::post('/edit/me', [
		'uses' => 'GeneralController@myEdit'
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