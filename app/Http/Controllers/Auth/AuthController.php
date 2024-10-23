<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Fonction de connexion
    public function login(Request $request)
    {
        try{ 
                $validatedData = $request->validate([
                    'email' => 'required|email',
                    'password' => 'required|min:8',
                ], [
                    'email.required' => 'L’adresse email est obligatoire.',
                    'email.email' => 'Veuillez fournir une adresse email valide.',
                    'password.required' => 'Le mot de passe est obligatoire.',
                    'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                ]);

                $user = User::where('email', $request->email)->first();

                // Vérifier si l'utilisateur existe et si le mot de passe est correct
                if (!$user || !Hash::check($request->password, $user->password)) {
                    throw ValidationException::withMessages([
                        'credentials' => ['Les informations de connexion sont incorrectes.'],
                    ]);
                }

                // Crée un token pour l'utilisateur
                $token = $user->createToken('auth_token')->plainTextToken;
                
                return response()->json([
                    'message' => 'Connexion réussie',
                    'access_token' => $token,
                    'user' => $user,
                    'token_type' => 'Bearer',
                ], 200);

            }catch(ValidationException $e){  
                return response()->json([
                    'message' => 'Erreur lors de l\'authentification',
                    'errors' => $e->errors(),
                ], 422);

            }
    }
    // Fonction de déconnexion
    public function logout(Request $request)
    {
        // Révoquer tous les tokens de l'utilisateur connecté
        $request->user()->tokens()->delete();
    
        // Retourner une réponse avec l'instruction de suppression du cookie
        return response()->json([
            'message' => 'Déconnexion réussie et les tokens ont été révoqués'
        ])->withCookie(cookie()->forget('access_token'));
    }
    

    // Fonction pour récupérer les détails de l'utilisateur connecté
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
