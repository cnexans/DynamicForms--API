# DynamicForms

DynamicForms is an enterprise solution for small companies, a generic mobile application that can be plenty configured with forms and fulfilled with answers. Small companies can use this project in order to build tools such as:

* Send alerts for issues (to the IT team, for example)
* Make inventory of stock with the phone
* Set order deliveries
* Make project management

The application implements three groups of users:
* Employee
* Manager
* President

They all can answer the forms through the mobile app but:
* Managers can configure the forms shown within the application
* Presidents can configure the forms and also the users.

The forms can be composed with the next inputs
* Integers
* Floating point numbers
* Short strings
* Text (large strings)
* QR Codes
* Dates
* Blob values
  * Images and photos
  * Editable images and photos
* Location (mobile's GPS)
* Options

## Parts

* [API](https://github.com/cnexans/DynamicForms--API)
* [Application](https://github.com/cnexans/DynamicForms--App)
* [Dashboard](https://github.com/cnexans/DynamicForms--Dashboard)

## API

This repository has been made with Laravel 5.1 and it is the intermediate point between the dashboard and the application.

### How does this works

The forms are created with three levels of abstraction

1. Forms
  * Are created by users
  * Has many field descriptors
    * Describes the fields attached to a form
    * It can be integer, float, string, blob, etc.
  * Has many form instances
2. Form instances
  * Has one user (who answered the form)
  * Has one form (the form that the user is answering)
  * Has many form answers (the data send in each field)
3. Form answers
  * Has one field descriptor
  * Has one data row (where to look at the answer)

### OAuth implemented

The available grant types are password, client and refresh

#### Password grant type

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


#### Refresh grant type

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
