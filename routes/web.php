<?php

use Illuminate\Support\Facades\Route;

// Redirect root URL langsung ke Admin Panel
Route::get('/', function () {
    return redirect('/admin/login');
});
