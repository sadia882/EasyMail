<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Mise à jour de la photo de profil
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->profile_photo) {
                Storage::delete($user->profile_photo);
            }

            // Stocker la nouvelle photo
            $path = $request->file('photo')->store('profile_photos');

            // Mettre à jour l'utilisateur avec le chemin de la nouvelle photo
            $user->profile_photo = $path;
            $user->save();
        }

        return response()->json(['message' => 'Profile photo updated successfully.', 'profile_photo' => $path]);
    }

    // Mise à jour de la signature
    public function updateSignature(Request $request)
    {
        $request->validate([
            'signature' => 'required|string|max:500',
        ]);

        $user = $request->user();
        $user->signature = $request->signature;
        $user->save();

        return response()->json(['message' => 'Signature updated successfully.']);
    }
}

