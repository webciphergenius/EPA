<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
    //return view('student_report');
});
Route::get('/pdf', function () {
    return view('student_report');
});