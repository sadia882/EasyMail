<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    
    {
        try {
            // Valider les données de la requête
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'Veuillez fournir une adresse e-mail valide.',
        ]);
        var_dump("validation passed");
        // Tentative d'envoi du lien de réinitialisation
        $status = Password::sendResetLink(
            $request->only('email')
        );
        // Vérification du statut et retour de la réponse appropriée
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Un lien de reinitialisation de mot de passe a ete envoye a votre adresse e-mail.'], 200);
        }

        if ($status === Password::INVALID_USER) {
            return response()->json(['message' => 'Aucun utilisateur trouvé avec cette adresse e-mail.'], 404);
        }

        // Pour d'autres erreurs, retournez un message générique
        return response()->json(['message' => 'Une erreur est survenue. Veuillez réessayer plus tard.'], 500);
        } catch (\Throwable $th) {
            return response()->json(['message' =>  $th->getMessage()], 500);
        }
        
    }
}
