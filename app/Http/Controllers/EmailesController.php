<?php

namespace App\Http\Controllers;

use App\Models\Emailes;
use App\Models\EmailAttachment;
use App\Mail\SendEmailWithAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class EmailesController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validation des données
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        try {
            // Créer l'email
            $email = Emailes::create([
                'to' => $request->to,
                'subject' => $request->subject,
                'body' => $request->body,
            ]);

            // Gérer les pièces jointes
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('attachments');
                    
                    // Assurez-vous que le fichier est correctement stocké
                    if (Storage::exists($path)) {
                        EmailAttachment::create([
                            'emailes_id' => $email->id,
                            'filename' => $file->getClientOriginalName(),
                            'path' => $path,
                        ]);
                    } else {
                        Log::warning("Le fichier téléchargé n'a pas pu être stocké: $path");
                    }
                }
            }

            // Envoyer l'email
            Mail::send(new SendEmailWithAttachments($email));

            return response()->json([
                'status' => 'success',
                'message' => 'Email envoyé avec succès.'
            ], 200);

        } catch (Exception $e) {
            // Log l'erreur
            Log::error('Erreur lors de l\'envoi de l\'email: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de l\'envoi de l\'email. Veuillez réessayer plus tard.'
            ], 500);
        }
    }

    public function getSentEmails()
    {
        try {
            // Récupérer tous les emails envoyés
            $emails = Emailes::all();
    
            return response()->json([
                'status' => 'success',
                'data' => $emails
            ], 200);
        } catch (Exception $e) {
            // Log l'erreur
            Log::error('Erreur lors de la récupération des emails: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la récupération des emails. Veuillez réessayer plus tard.'
            ], 500);
        }
    }
    

}





    
