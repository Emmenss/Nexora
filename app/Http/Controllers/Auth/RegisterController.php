<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validation des données avec des messages d'erreur personnalisés
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:15|unique:users',
                'birthday' => 'required|date',
                'address' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'name.required' => 'Le champ nom est obligatoire.',
                'email.required' => 'Le champ email est obligatoire.',
                'email.email' => 'Veuillez entrer une adresse email valide.',
                'email.unique' => 'Cette adresse email est déjà utilisée.',
                'phone.required' => 'Le champ téléphone est obligatoire.',
                'phone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
                'birthday.required' => 'Le champ date de naissance est obligatoire.',
                'address.required' => 'Le champ adresse est obligatoire.',
                'password.required' => 'Le champ mot de passe est obligatoire.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            ]);

            // Création de l'utilisateur
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'birthday' => $request->birthday,
                'address' => $request->address,
                'password' => Hash::make($request->password),
            ]);

            // Retourne une réponse JSON en cas de succès
            return response()->json([
                'message' => 'Utilisateur enregistré avec succès',
                'user' => $user,
            ], 201);
            
        } catch (ValidationException $e) {
            // Capture les erreurs de validation et retourne une réponse JSON
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        }
    }
}
