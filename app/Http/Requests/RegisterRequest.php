<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Autoriser cette requête
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20|unique:users,telephone',
            'password' => 'required|string|min:8',
        ];
    }

    /**
     * Personnalisation des messages d'erreur.
     */
    public function messages()
    {
        return [
            'nom.required' => 'Un nom doit être fourni.',
            'prenom.required' => 'Un prénom doit être fourni.',
            'telephone.required' => 'Un numéro de téléphone doit être fourni.',
            'telephone.unique' => 'Le numéro de téléphone est déjà utilisé.',
            'password.required' => 'Un mot de passe doit être fourni.',
        ];
    }
}
