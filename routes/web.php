<?php

use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
  return view('layouts.template');
});

Route::get('mySillyPage', function () {
  // abort with error 404
  //return abort('404');
  // abort with error 403 (default error message)
  // return abort('403');
  // abort with error 403 (custom error message)
  return abort('403', 'Mi tonto error');
});