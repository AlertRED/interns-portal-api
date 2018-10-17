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
        Route::get('/homework_statuses', 'Homework\HomeworkController@getHomeworkStatuses');

        /* Current user actions */

        Route::group([
            'prefix' => 'me'
        ], function ()
        {
            Route::get('/profile_info', 'User\UsersController@getMyProfileInfo');
            Route::patch('/profile_info', 'User\UsersController@editMyProfileInfo');

            Route::get('/homeworks', 'Homework\InternHomeworkController@getMyHomeworks');
            Route::get('/homework/{intern_homework}', 'Homework\InternHomeworkController@get');
            Route::patch('/homework/{intern_homework}', 'Homework\InternHomeworkController@edit');
        });

        /*
         |-----------------------------------------------------------------------
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
                Route::get('/{user}', 'User\UsersController@getUser');
                Route::get('/{user}/homeworks', 'Homework\InternHomeworkController@getUserHomeworks');
                Route::get('/{user}/homework/{intern_homework}', 'Homework\InternHomeworkController@getUserHomework');
                Route::patch('/{user}/homework/{intern_homework}', 'Homework\InternHomeworkController@editUserHomework');
            });

            /* Homeworks */

            Route::get('/homeworks', 'Homework\HomeworkController@getAll');

            Route::group([
                'prefix' => 'homework'
            ], function () {

                Route::post('/', 'Homework\HomeworkController@new');
                Route::get('/{homework}', 'Homework\HomeworkController@get');
                Route::patch('/{homework}', 'Homework\HomeworkController@edit');
                Route::delete('/{homework}', 'Homework\HomeworkController@delete');

                Route::post('/{homework}/course', 'Homework\HomeworkController@addCourse');
            });
        });
    });
});
