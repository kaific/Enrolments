<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'API\PassportController@user');
    Route::get('logout', 'API\PassportController@logout');

    Route::resource('courses', 'API\CourseController')->except([
        'create', 'edit'
    ]);
    Route::resource('students', 'API\StudentController')->except([
        'create', 'edit'
    ]);
    Route::resource('enrolments', 'API\EnrolmentController')->except([
        'create', 'edit'
    ]);
});
