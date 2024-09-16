<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BadienGox;
use App\Models\Patiente;
use App\Models\SageFemme;
use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        // Valider les données d'entrée
        $request->validate([
            'login' => 'required|string', // Peut être email ou numéro de téléphone
            'password' => 'required|string',
        ]);
    
        // Identifier si 'login' est un email ou un numéro de téléphone
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
    
        // Créer les identifiants pour la tentative de connexion
        $credentials = [
            $loginField => $request->login,
            'password' => $request->password,
        ];
    
        // Tenter de se connecter
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Récupérer l'utilisateur connecté
        $user = auth()->user();
    
        // Récupérer les rôles de l'utilisateur (Spatie)
        $roles = $user->getRoleNames(); // Cela retourne un tableau de rôles
    
        // Retourner la réponse avec les informations de l'utilisateur et le token
        return response()->json([
            'message' => 'Connexion réussie',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'prenom' => $user->prenom,
                'nom' => $user->nom,
                'email' => $user->email,
                'telephone' => $user->telephone,
                'roles' => $roles, // Rôles de l'utilisateur
            ]
        ], 200);
    }
    

}
