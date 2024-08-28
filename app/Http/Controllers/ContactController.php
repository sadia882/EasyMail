<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

use App\Mail\ContactEmail; 
use Illuminate\Http\Request;
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
// Création de contact à partir de l'id du user dans la table users

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:contacts',
            'user_id' => 'required|integer',  
        ]);
    
        $userId = $request->user_id;
    
        $contact = Contact::create([
            'user_id' => $userId,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
            'email' => $request->email,
        ]);
    
        \Log::info('Contact created:', ['contact' => $contact]);
    
        return response()->json([
            'status' => 201,
            'message' => 'Contact créé avec succès !',
            'results' => $contact,
        ]);
    }
        

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:contacts,email,' . $id,
            'user_id' => 'required|integer',
        ]);
    
        // Trouver le contact par ID
        $contact = Contact::find($id);
    
        if (!$contact) {
            return response()->json([
                'status' => 404,
                'message' => 'Contact non trouvé.',
            ], 404);
        }
    
        // Mettre à jour les informations du contact
        $contact->update([
            'user_id' => $request->user_id,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
            'email' => $request->email,
        ]);
    
        \Log::info('Contact updated:', ['contact' => $contact]);
    
        // Répondre avec succès
        return response()->json([
            'status' => 200,
            'message' => 'Contact mis à jour avec succès !',
            'results' => $contact,
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
    