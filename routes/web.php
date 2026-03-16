<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'guest')->middleware('guest')->name('login');
Route::view('/{any}', 'app')->middleware('auth')->where('any', '^(?!api).*$');
