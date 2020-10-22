<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

/* Route::get('/', function () {
  return view('layouts.template');
}); */

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
// Route::get('/home', 'HomeController@index')->name('home');
Route::redirect('home', '/');
Route::view('/', 'home');

/* Route::get('mySillyPage', function () {
  // abort with error 404
  return abort('404');
  // abort with error 403 (default error message)
  // return abort('403');
  // abort with error 403 (custom error message)
  // return abort('403', 'Mi tonto error');
}); */

/* Route::get('/contacto', function () {
  return view('contact');
}); */

// Old version
/* Route::get('admin/records', function () {
  $records = [
    'Queen - <b>Greatest Hits</b>',
    'The Rolling Stones - <em>Sticky Fingers</em>',
    'The Beatles - Abbey Road'
  ];

  return view('admin.records.index', [
      'records' => $records
  ]);
}); */

// New version with prefix and group
/* Route::prefix('admin')->group(function () {
  Route::redirect('/', '/admin/records');
  
  Route::get('records', function (){
    $records = [
      'Queen - <b>Greatest Hits</b>',
      'The Rolling Stones - <em>Sticky Fingers</em>',
      'The Beatles - Abbey Road'
    ];
    return view('admin.records.index', [
        'records' => $records
    ]);
  });
}); */

/* Route::view('/', 'home');
Route::view('contacto', 'contact'); */
Route::get('contact-us', 'ContactUsController@show');
Route::post('contact-us', 'ContactUsController@sendEmail');

Route::get('shop', 'ShopController@index');
Route::get('shop/{id}', 'ShopController@show');

/* Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
  Route::redirect('/', 'records');
  Route::get('records', 'Admin\RecordController@index');
  Route::resource('genres', 'Admin\GenreController');
}); */

Route::group([
  'middleware' => ['auth', 'admin'],
  'prefix'     => 'admin',
  'namespace'  => 'Admin'],
  function () {
    Route::redirect('/', 'records');
    // http://localhost:3000/admin/genres/qryGenres
    Route::get('genres/qryGenres', 'GenreController@qryGenres');
    Route::resource('genres', 'GenreController');
    Route::resource('records', 'RecordController');
  });

/* Route::middleware(['auth'])->prefix('user')->group(function () {
  Route::redirect('/', '/user/profile');
  Route::get('profile', 'User\ProfileController@edit');
  Route::post('profile', 'User\ProfileController@update');
}); */

Route::group([
  'middleware' => ['auth'],
  'prefix'     => 'user',
  'namespace'  => 'User'],
  function () {
    Route::redirect('/', '/user/profile');
    Route::get('profile', 'ProfileController@edit');
    Route::post('profile', 'ProfileController@update');
    Route::get('password', 'PasswordController@edit');
    Route::post('password', 'PasswordController@update');
  }
);