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
     | User routes
     |-----------------------------------------------------------------------
     */

    /* Current user actions */

    Route::group([
        'prefix' => 'me', 'middleware' => ['auth:api']
    ], function ()
    {
        Route::get('/profile_info', 'User\UsersController@getMyProfileInfo');
        Route::patch('/profile_info', 'User\UsersController@editMyProfileInfo');


        Route::get('/homeworks', 'Homework\InternHomeworkController@getMyHomeworks');
    });

    /*
     |-------------------------:----------------------------------------------
     | Employee only routes
     |-----------------------------------------------------------------------
     */

    Route::group([
        'middleware' => ['auth:api', 'employee-only']
    ], function ()
    {
        /* Courses */
        Route::get('/courses', 'Course\InternshipCoursesController@all');

        /* Users */
        Route::get('/interns', 'User\UsersController@getInterns');

        Route::get('/user/{id}', 'User\UsersController@getUser');

        /* Homeworks */

        Route::get('/homeworks', 'Homework\HomeworkController@getAll');

        Route::post('/homework', 'Homework\HomeworkController@new');
        Route::get('/homework/{id}', 'Homework\HomeworkController@get');
        Route::patch('/homework/{id}', 'Homework\HomeworkController@edit');
        Route::delete('/homework/{id}', 'Homework\HomeworkController@delete');
    });
});
