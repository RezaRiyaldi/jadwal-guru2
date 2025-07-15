<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/admin/dashboard');
});

Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});