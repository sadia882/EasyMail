<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Exception;
use App\Models\User;
use App\Http\Requests\RegisterRequest;


class RegisterController extends Controller
{
    use HasApiTokens, Notifiable;

    public function registre(RegisterRequest $request){
        try {
            $user = new User();
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->email = $request->email;
            $user->telephone = $request->telephone;
            $user->password = $request->password;
            $user->save();

            return response()->json([
                'statuts' => 200,
                'message' => 'Utilisateur a été enregistré avec succès !',
                'results' => [
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'telephone' => $user->telephone,
                    // 'email' => $user->email,
                    'password' => $user->password,
                ],
            ]);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    
}
