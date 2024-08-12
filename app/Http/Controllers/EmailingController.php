<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\EmailAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class EmailingController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'to' => 'required|email',
            'body' => 'required|string',
            'subject' => 'required|string',
            'attachments.*' => 'file' 
        ]);

        try {
            // Création de l'email
            $email = Email::create([
                'to' => $validatedData['to'],
                'body' => $validatedData['body'],
                'subject' => $validatedData['subject'],
            ]);

            // Traitement des pièces jointes
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Vérification si le fichier est valide
                    if ($file->isValid()) {
                        $filePath = $file->store('attachments', 'public');

                        EmailAttachment::create([
                            'email_id' => $email->id,
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $filePath,
                            'file_mime_type' => $file->getMimeType(),
                        ]);
                    } else {
                        // Gestion des fichiers invalides
                        return response()->json(['error' => 'Un ou plusieurs fichiers joints sont invalides.'], 400);
                    }
                }
            }

            return response()->json($email, 201);
        } catch (Exception $e) {
            // Enregistrement de l'erreur dans les logs
            Log::error('Erreur lors de l\'envoi de l\'email: ' . $e->getMessage());

            // Retour d'une réponse d'erreur générique
            return response()->json(['error' => 'Une erreur est survenue lors du traitement de votre demande.'], 500);
        }
    }
}
