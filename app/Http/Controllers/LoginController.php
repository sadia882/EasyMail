<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class LoginController extends Controller
{
    use HasApiTokens, Notifiable;

    public function login(LoginRequest $request)
    {
        if (auth()->attempt($request->only(['email', 'password']))) {
            $user = auth()->user();
            $token = $user->createToken("MA_CLE_SECRETE_VISIBLE_UNIQUEMENT_AU_BACKEND")->plainTextToken;

            return response()->json([
                'statuts' => 200,
                'message' => 'Utilisateur connecté avec succées !',
                'results' => [
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'telephone' => $user->telephone,
                    'email' => $user->email,
                ],
                'token' => $token
            ]);

        } else {
            return response()->json([
                'statuts' => 403,
                'message' => 'Informations non valides.'
            ]);
        }
    }
}
