<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function registre(Request $request)
    {
        try {
            // Validation des données
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'telephone' => 'required|string|max:15',
                'password' => 'required|string|min:8',
            ]);
    
            // Génération de l'adresse email
            $email = strtolower($request->prenom . '.' . $request->nom . '@easymail.com');
    
            // Vérification de l'unicité de l'email
            if (User::where('email', $email)->exists()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'L\'adresse email est déjà utilisée.',
                ]);
            }
    
            // Création de l'utilisateur
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => $request->telephone,
                'password' => Hash::make($request->password),
                'email' => $email,
            ]);
    
            return response()->json([
                'status' => 200,
                'message' => 'Utilisateur enregistré avec succès !',
                'results' => [
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'telephone' => $user->telephone,
                    'email' => $user->email,
                ],
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Error in RegisterController@registre: ' . $e->getMessage());
    
            return response()->json([
                'status' => 500,
                'message' => 'Une erreur s\'est produite lors de l\'enregistrement de l\'utilisateur.',
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    // public function show($id)
    // {
    //     try {
    //         $user = User::findOrFail($id);

    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Utilisateur trouvé avec succès !',
    //             'results' => [
    //                 'nom' => $user->nom,
    //                 'prenom' => $user->prenom,
    //                 'telephone' => $user->telephone,
    //                 'email' => $user->email,
    //             ],
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'Utilisateur non trouvé.',
    //             'error' => $e->getMessage(),
    //         ]);
    //     }
    // }
}
