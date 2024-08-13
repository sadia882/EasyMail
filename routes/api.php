<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\RegisterController;
// use App\Http\Controllers\LoginController;

// use App\Http\Controllers\ForgotPasswordController;
// use App\Http\Controllers\ResetPasswordController;

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
//Route::post('/register', [RegisterController::class, 'registre']);
//recuperer les donnees du user
// Route::get('/users/{id}', [RegisterController::class, 'show']);

// Route::get('/users/{id}', [RegisterController::class, 'show']);
// Route::get('/users', [RegisterController::class, 'index']);
// Route::post('/login', [LoginController::class, 'login']);

// Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);
// Route::post('password/reset', [ResetPasswordController::class, 'reset']);

// Route pour envoyer le lien de réinitialisation de mot de passe
// Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Route pour afficher le formulaire de réinitialisation de mot de passe
// Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Route pour soumettre la demande de réinitialisation de mot de passe
// Route::post('update/password', [ResetPasswordController::class, 'reset'])->name('password.update');



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('forgot-password', [ForgotPasswordController::class, 'sendOtp']);
// Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);

// Autres routes
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

///...........................................................................

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

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

// Route pour enregistrer un nouvel utilisateur
Route::post('/register', [RegisterController::class, 'registre']);

// Route pour récupérer les données d'un utilisateur par ID
Route::get('/users/{id}', [RegisterController::class, 'show']);

// Route pour récupérer tous les utilisateurs
Route::get('/users', [RegisterController::class, 'index']);

// Route pour authentifier un utilisateur
Route::post('/login', [LoginController::class, 'login']);

// Route pour envoyer le lien de réinitialisation de mot de passe
Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Route pour afficher le formulaire de réinitialisation de mot de passe
// Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Route pour soumettre la demande de réinitialisation de mot de passe
// Route::post('update/password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Route pour obtenir les informations de l'utilisateur authentifié (nécessite une authentification via Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//
// Route pour envoyer le lien de réinitialisation de mot de passe
Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Route pour afficher le formulaire de réinitialisation de mot de passe
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Route pour soumettre la demande de réinitialisation de mot de passe
Route::post('update/password', [ResetPasswordController::class, 'reset'])->name('password.update');

//Routes de Gestion des Utilisateurs
// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     Route::post('/users', [AdminController::class, 'store']);
//     Route::delete('/users/{id}', [AdminController::class, 'destroy']);
// });
