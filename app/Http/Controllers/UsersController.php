<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function store(Request $request)
{
    $validatedData = $request->validate([
       'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'telephone' => 'required|string|max:15',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'telephone' => $request->telephone,
        'email' => $request->email,
        'role' => 'client',
        'password' => Hash::make($request->password),
    ]);

    return response()->json($user, 201); // Retourner une réponse JSON
}

    //Destroy
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

//Vérification des permissions dans les contrôleurs :
    public function someAdminAction()
    {
        $this->authorize('manage users');

        // Action réservée aux administrateurs
    }

}
