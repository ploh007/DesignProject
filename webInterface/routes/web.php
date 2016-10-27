<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


// Route to home landing page
Route::get('/', function () {
    return view('home');
});

// Route to home landing page
Route::get('/home', function () {
    return view('home');
});

// Route to Gesture Notifier Demo App
Route::get('/gestureNotifier', function () {
    return view('apps.gestureNotifier');
})->middleware('auth');

// Route to Globe Controller Demo App
Route::get('/globeController', function () {
    return view('apps.globeController');
})->middleware('auth');

// Route to Calibration App
Route::get('/calibration', function () {
    return view('apps.calibration');
})->middleware('auth');

// Route to Presentation App
Route::get('/presentation', function () {
    return view('apps.presentation');
})->middleware('auth');

// Route to Admin Controls
Route::get('/admin', 'HomeController@index');

// Route to Help Page
Route::get('/help', function () {
    return view('help');
});

Route::get('/database', "DeviceController@index");

Route::post('/database', 'DeviceController@store');

Auth::routes();
	