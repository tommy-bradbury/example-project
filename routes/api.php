<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix'=>"v1"], function() {
    Route::group(['prefix'=>"courses"], function() {

        Route::get('/', function () {
            return 'test';
        });
        
        //Provision a course to a user (using POST)
        Route::post('/assignCourse', 'App\Http\Controllers\CourseAssignmentsController@create');

        // Get all courses assigned to a user (using GET)
        Route::get('/showAllAssignedCourses/{user_id}', 'App\Http\Controllers\CourseAssignmentsController@show');

        //Fetch course info
        Route::post('/allCourseInfo', 'App\Http\Controllers\CoursesController@getAllCourseInfo');

        
        //Log the completion of a course
        Route::post('/complete', 'App\Http\Controllers\CourseAssignmentsController@completeCourse');

        
        // remove the assignment of a course
        Route::post('/archive', 'App\Http\Controllers\CourseAssignmentsController@archiveCourse');

    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
