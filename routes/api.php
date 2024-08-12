<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MailingController;
use App\Http\Controllers\EmailingController;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [RegisterController::class, 'registre']);
// Route::get('/user/{id}', [RegisterController::class, 'show']);
Route::post('/login', [LoginController::class, 'login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('/emails', [EmailController::class, 'index']);
Route::post('/sendEmail', [EmailController::class, 'sendEmail']);
// Route::get('/emails/all', [EmailController::class, 'getEmails']);
// Route::delete('/emails/{id}', [EmailController::class, 'deleteEmail']);


// Route::post('/basicEmail',[MailController::class,"send_basic_email"]);
// Route::post('/basichtmlEmail',[MailController::class,"send_html_email"]);
// Route::post('/send_attach_email',[MailController::class,"send_attach_email"]);


// routes/api.php


// Route::get('/contacts', [MailingController::class, 'getContacts']);
// Route::post('/send-email', [MailingController::class, 'sendEmail']);

Route::post('emails', [EmailingController::class, 'store']);



