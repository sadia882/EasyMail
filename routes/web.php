<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoiteReceptionController;
use App\Http\Controllers\EmailController;

Route::get('/', function () {
    return view('welcome');
});



Route::post('/send-email', [EmailController::class, 'sendEmail']);

