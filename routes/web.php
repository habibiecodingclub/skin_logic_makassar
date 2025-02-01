<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd("halo");
    return view('welcome');
});
