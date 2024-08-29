<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

use App\Mail\ContactEmail; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    public function index()
    {
        // Récupérer tous les contacts
        $contacts = Contact::all();
    
        return response()->json([
            'status' => 200,
            'message' => 'Contacts récupérés avec succès !',
            'results' => $contacts,
        ]);
    }


    public function getContactsByUser($userId)
{
    // Vérifier si l'utilisateur existe
    $user = User::find($userId);

    if (!$user) {
        return response()->json([
            'status' => 404,
            'message' => 'Utilisateur non trouvé.',
        ], 404);
    }

    // Récupérer un contact spécofique à l'id
    $contacts = $user->contacts;

    return response()->json([
        'status' => 200,
        'message' => 'Contacts récupérés avec succès !',
        'results' => $contacts,
    ]);
}

// Pour Mettre à jour
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);
    
    
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Utilisateur non trouvé.',
            ], 404);
        }

        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'role' => $user->role, // Garder le rôle existant
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Trouver le contact associé
        $contact = Contact::where('user_id', $user->id)->first();

        if (!$contact) {
            return response()->json([
                'status' => 404,
                'message' => 'Contact non trouvé.',
            ], 404);
        }

        // Mettre à jour les informations du contact
        $contact->update([
            'telephone' => $request->telephone,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Informations mises à jour avec succès !',
            'results' => [
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'telephone' => $contact->telephone,
                'email' => $user->email,
            ],
        ]);
    }
    
        
    public function destroy($id)
    {
        // Trouver le contact par ID
        $contact = Contact::find($id);
    
        if (!$contact) {
            return response()->json([
                'status' => 404,
                'message' => 'Contact non trouvé.',
            ], 404);
        }
    
        // Supprimer le contact
        $contact->delete();
    
        \Log::info('Contact deleted:', ['contact_id' => $id]);
    
        // Répondre avec succès
        return response()->json([
            'status' => 200,
            'message' => 'Contact supprimé avec succès !',
        ]);
    }
    
    
    
        public function sendEmail($id, Request $request)
        {
            // Find the contact by ID
            $contact = Contact::find($id);
    
            if (!$contact) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Contact non trouvé.',
                ], 404);
            }
    
            // Validate the request data for the email
            $validated = $request->validate([
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);
    
            // Send the email
            try {
                Mail::to($contact->email)->send(new ContactEmail($validated['subject'], $validated['message']));
                
                return response()->json([
                    'status' => 200,
                    'message' => 'Email envoyé avec succès !',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Erreur lors de l\'envoi de l\'email.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }
    