<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;


class ContactController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }
        $contacts = $user->contacts; // Récupère les contacts de l'utilisateur connecté
        return response()->json($contacts);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:contacts,email',
            'telephone' => 'nullable|string',
        ]);

        $contact = auth()->user()->contacts()->create($request->all());

        return response()->json($contact, 201);
    }

    public function show($id)
    {
        $contact = auth()->user()->contacts()->findOrFail($id);
        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        $contact = auth()->user()->contacts()->findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|required|string',
            'prenom' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:contacts,email,' . $contact->id,
            'telephone' => 'nullable|string',
        ]);

        $contact->update($request->all());

        return response()->json($contact);
    }

    public function destroy($id)
    {
        $contact = auth()->user()->contacts()->findOrFail($id);
        $contact->delete();

        return response()->json(['message' => 'Contact supprimé avec succès.']);
    }
}
