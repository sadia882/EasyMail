<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class EmailController extends Controller
{
    public function create()
    {
        return view('email.create');
    }

    public function send(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        try {
            // Créer un enregistrement de l'email
            $email = Email::create($request->all());

            // Préparer les détails de l'email
            $details = [
                'subject' => $request->subject,
                'message' => $request->message
            ];

            // Envoyer l'email
            Mail::to($request->to)->send(new SendEmail($details));

            // Retourner une réponse avec le code de statut 200
            return Response::json(['success' => 'Email envoyé avec succès!'], 200);

        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec le code de statut 500
            return Response::json(['error' => 'Échec de l\'envoi de l\'email.'], 500);
        }
    }

    public function index()
    {
        // Récupérer tous les emails de la base de données
        $emails = Email::all();

        // Retourner une réponse JSON avec les emails
        return Response::json($emails, 200);
    }

    public function destroy($id)
    {
        try {
            // Trouver l'email par ID
            $email = Email::findOrFail($id);

            // Supprimer l'email
            $email->delete();

            // Retourner une réponse avec le code de statut 200
            return Response::json(['success' => 'Email supprimé avec succès!'], 200);

        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec le code de statut 500
            return Response::json(['error' => 'Échec de la suppression de l\'email.'], 500);
        }
    }
}
