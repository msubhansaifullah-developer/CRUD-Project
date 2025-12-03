<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/', function () {
    return view('login');
});
Route::post('signup/register', [AuthController::class, 'signup']);
Route::view('allposts','allposts');
Route::view('addposts','addpost');
Route::view('/signup','signup');
