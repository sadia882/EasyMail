<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// class ResetPasswordController extends Controller
// {
//     public function reset(Request $request)
//     {
//         // Valider les données de la requête
//         $request->validate([
//             'token' => 'required',
//             'email' => 'required|email',
//             'password' => 'required|string|min:8|confirmed',
//         ], [
//             'token.required' => 'Le token de réinitialisation est requis.',
//             'email.required' => 'L\'adresse e-mail est requise.',
//             'email.email' => 'L\'adresse e-mail doit être valide.',
//             'password.required' => 'Le mot de passe est requis.',
//             'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
//             'password.confirmed' => 'Les mots de passe ne correspondent pas.',
//         ]);

//         // Tentative de réinitialisation du mot de passe
//         $status = Password::reset(
//             $request->only('email', 'password', 'password_confirmation', 'token'),
//             function ($user, $password) {
//                 $user->password = Hash::make($password);
//                 $user->save();
//             }
//         );

//         // Vérification du statut et retour de la réponse appropriée
//         if ($status === Password::PASSWORD_RESET) {
//             return response()->json(['message' => 'Votre mot de passe a été réinitialisé avec succès.'], 200);
//         }

//         return response()->json(['message' => 'Échec de la réinitialisation du mot de passe. Veuillez vérifier votre token et essayer de nouveau.'], 400);
//     }
// }

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
            ]);
    
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();
                }
            );
    
            if ($status == Password::PASSWORD_RESET) {
                return response()->json(['message' => 'Mot de passe réinitialisé avec succès.'], 200);
            }
    
            return response()->json(['message' => $status . 'Erreur lors de la réinitialisation du mot de passe.'], 500);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
        
    }
}