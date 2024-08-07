<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoiteReceptionController;
use App\Http\Controllers\EmailController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/send-mail', [EmailController::class, 'sendEmail']);
Route::get('/emails', [EmailController::class, 'getEmails']);
Route::get('/emails/{id}', [EmailController::class, 'deleteEmail']);
