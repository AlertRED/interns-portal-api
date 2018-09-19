<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api/v1', 'as' => 'api.v1.'], function ()
{
    /*
     |-----------------------------------------------------------------------
     | Public routes
     |-----------------------------------------------------------------------
     */
    Route::post('/login', 'Auth\AuthController@login');
    Route::post('/register', 'Auth\AuthController@register');

    Route::get('/check_api_token', 'Auth\AuthController@checkApiToken');

    /*
     |-----------------------------------------------------------------------
     | Employee only routes
     |-----------------------------------------------------------------------
     */

    Route::group([
        'middleware' => ['auth:api', 'employee-only']
    ], function ()
    {
        Route::get('/user/{id}/get', 'User\UsersController@getUser');
    });
});