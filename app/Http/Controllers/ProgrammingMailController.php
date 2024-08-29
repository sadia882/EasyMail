<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProgrammingMailController extends Controller
{
    public function scheduleEmail(Request $request)
    {
        // Validation des données de la requête
        $validated = $request->validate([
            'email' => 'required|email',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Préparer les détails de l'email
        $details = [
            'email' => $validated['email'],
            'title' => $validated['title'],
            'body' => $validated['body']
        ];

        // Définir le délai pour l'envoi de l'email
        $delay = Carbon::now()->addMinutes(2); // Planifier l'envoi dans 2 minutes

        // Dispatcher le job avec le délai spécifié
        SendEmailJob::dispatch($details)->delay($delay);

        return response()->json(['message' => 'Email programmé envoyé avec succès']);
    }
}
