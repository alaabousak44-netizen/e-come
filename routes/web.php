<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('travel');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/search-results', function () {
    return view('search-results');
});
