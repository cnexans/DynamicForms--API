# Laravel5OauthSeed

This repository initializes a laravel 5 project with BShaffer Oauth package for PHP

Grant types: password, client and refresh

Password grant type
servername/oauth/token
{
  grant_type : 'password',
  username : 'username@registered.in.the.app.com',
  password : 'password of the user',
  client_id : 'testclient',
  client_secret: 'testpass'
}
Response
{
  "access_token": "02108d2b51a6cb88842846746f37c30602cec121",
  "expires_in": 3600,
  "token_type": "Bearer",
  "scope": null,
  "refresh_token": "b01b1fe56ec493bc3afd861dfc92cab64523b42c"
}


Refresh grant type
servername/oauth/token
{
  grant_type : 'refresh',
  refresh_token : 'the refresh token given in password grant type',
  client_id: 'testclient',
  client_secret: 'testpass'
}
Response
{
  "access_token": "73b746eb4b2e7188b7fcfbd622e33b6387968e60",
  "expires_in": 3600,
  "token_type": "Bearer",
  "scope": null
}

Example controller method using Oauth middleware (PostController@index)
servername/
(x-www-form-urlencoded)
{
  access_token : '02108d2b51a6cb88842846746f37c30602cec121'
}
Response
{
  "user_id": "1"
}
Where 1 is the user_id is related to the access token. 
If no access token given
{
  "error": "Token not found"
}
If invalid access token
{
  "error": "Invalid access token"
}


THis is done adding $this->middleware('oauth'); to the controller, the middleware returns the user_id related to the access token if everything went fine.
