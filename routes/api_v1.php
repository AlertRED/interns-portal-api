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

    Route::group([
        'middleware' => ["auth:api"]
    ], function ()
    {

        /* Current user actions */

        Route::group([
            'prefix' => 'me'
        ], function ()
        {
            Route::get('/profile_info', 'User\UsersController@getMyProfileInfo');
            Route::patch('/profile_info', 'User\UsersController@editMyProfileInfo');

            Route::get('/homeworks', 'Homework\InternHomeworkController@getMyHomeworks');
            Route::get('/homework/{id}', 'Homework\InternHomeworkController@get');
            Route::patch('/homework/{id}', 'Homework\InternHomeworkController@edit');
        });

        /* homeworks */

        Route::get('/user/{id}/homework/{homework_id}', 'Homework\InternHomeworkController@getUserHomework');

        /*
         |-------------------------:----------------------------------------------
         | Employee only routes
         |-----------------------------------------------------------------------
         */

        Route::group([
            'middleware' => ['employee-only']
        ], function ()
        {
            /* Courses */
            Route::get('/courses', 'Course\InternshipCoursesController@all');

            /* Users */
            Route::get('/interns', 'User\UsersController@getInterns');


            Route::group([
                'prefix' => 'user'
            ], function ()
            {
                Route::get('/{id}', 'User\UsersController@getUser');
                Route::get('/{id}/homeworks', 'Homework\InternHomeworkController@getUserHomeworks');
                Route::patch('{id}/homework/{homework_id}', 'Homework\InternHomeworkController@editUserHomework');
            });

            /* Homeworks */

            Route::get('/homeworks', 'Homework\HomeworkController@getAll');

            Route::post('/homework', 'Homework\HomeworkController@new');
            Route::get('/homework/{id}', 'Homework\HomeworkController@get');
            Route::patch('/homework/{id}', 'Homework\HomeworkController@edit');
            Route::delete('/homework/{id}', 'Homework\HomeworkController@delete');
        });

    });
});
