# DynamicForms--api

This project has been made with Laravel 5.1 is used by DynamicForms--app and DynamicForms--dashboard.



## About the OAuth2 usage

Grant types: password, client and refresh

### Password grant type

servername/oauth/token
```javascript
{
  grant_type : 'password',
  username : 'username@registered.in.the.app.com',
  password : 'password of the user',
  client_id : 'testclient',
  client_secret: 'testpass'
}
```

Response
```javascript
{
  "access_token": "02108d2b51a6cb88842846746f37c30602cec121",
  "expires_in": 3600,
  "token_type": "Bearer",
  "scope": null,
  "refresh_token": "b01b1fe56ec493bc3afd861dfc92cab64523b42c"
}
```


### Refresh grant type

servername/oauth/token
```javascript
{
  grant_type : 'refresh',
  refresh_token : 'the refresh token given in password grant type',
  client_id: 'testclient',
  client_secret: 'testpass'
}
```
Response
```javascript
{
  "access_token": "73b746eb4b2e7188b7fcfbd622e33b6387968e60",
  "expires_in": 3600,
  "token_type": "Bearer",
  "scope": null
}
```
