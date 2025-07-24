<?php

use Illuminate\Support\Facades\Route;

// Filament admin routes are automatically registered at /admin
Route::get('/', function () {
    return view('welcome');
});
