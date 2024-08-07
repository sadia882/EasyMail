<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

// Routes d'authentification
//Route::auth();
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
Route::post('/login', [LoginController::class, 'login']);

// Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);
// Route::post('password/reset', [ResetPasswordController::class, 'reset']);

// Route pour envoyer le lien de réinitialisation de mot de passe
Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Route pour afficher le formulaire de réinitialisation de mot de passe
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Route pour soumettre la demande de réinitialisation de mot de passe
Route::post('update/password', [ResetPasswordController::class, 'reset'])->name('password.update');



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('forgot-password', [ForgotPasswordController::class, 'sendOtp']);
// Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);

// Autres routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

