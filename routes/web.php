<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    Route::group(['prefix'=>"courses"], function() {

        Route::get('/', function() {
            return view('myCoursesHome');
        });

        Route::get('/admin', function() {
            return view('myCoursesAdmin');
        });

    });

    Route::get('/', function () {
        return redirect('/courses');
    });
    Route::get('/home', function () {
        return redirect('/courses');
    });


});
