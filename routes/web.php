<?php

use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
  return view('layouts.template');
});

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
Route::view('contacto', 'contact');

Route::view('/', 'home');

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
Route::prefix('admin')->group(function () {
  Route::redirect('/', 'records');
  Route::get('records', 'Admin\RecordController@index');
});
