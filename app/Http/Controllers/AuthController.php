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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

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
                'adresse' => $user->adresse,
                'photo' => $user->photo,
                'roles' => $roles, // Rôles de l'utilisateur
            ]
        ], 200);
    }
    public function logout(Request $request)
    {
        try {
            // Invalider le jeton JWT
            JWTAuth::parseToken()->invalidate();

            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout', 'exception' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Valider les données d'entrée
        $request->validate([
            // 'prenom' => 'nullable|string|max:255',
            // 'nom' => 'nullable|string|max:255',
            // 'adresse' => 'nullable|string|max:255',
            // 'email' => 'nullable|string|email|max:255|unique:users,email,' . auth()->user()->id,
            // 'telephone' => 'nullable|string|unique:users,telephone,' . auth()->user()->id,
            // 'old_password' => 'nullable|string',
            // 'password' => 'nullable|string|min:8|confirmed',
            // 'password_confirmation' => 'nullable|string|min:8',
            // 'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        // Mettre à jour les informations de l'utilisateur
        $user->prenom = $request->input('prenom');
        $user->nom = $request->input('nom');
        $user->adresse = $request->input('adresse');
        $user->email = $request->input('email');
        $user->telephone = $request->input('telephone');

        // Mettre à jour la photo de profil si fournie
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo) {
                Storage::delete('public/' . $user->photo);
            }
            // Enregistrer la nouvelle photo
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/photos', $filename);
            $user->photo = 'photos/' . $filename;
        }

        // Mettre à jour le mot de passe si l'ancien mot de passe et le nouveau sont fournis
        if ($request->filled('old_password') && $request->filled('password')) {
            if (!Hash::check($request->input('old_password'), $user->password)) {
                return response()->json(['error' => 'L\'ancien mot de passe est incorrect'], 401);
            }
            $user->password = Hash::make($request->input('password'));
        }

        // Enregistrer les modifications
        $user->save();

        // Retourner la réponse avec les informations de l'utilisateur mis à jour
        return response()->json([
            'message' => 'Profil mis à jour avec succès',
            'user' => [
                'id' => $user->id,
                'prenom' => $user->prenom,
                'nom' => $user->nom,
                'email' => $user->email,
                'adresse' => $user->adresse,
                'telephone' => $user->telephone,
                'photo' => $user->photo ? asset('storage/app/public' . $user->photo) : null, // Chemin vers la photo
                'roles' => $user->getRoleNames(), // Rôles de l'utilisateur
            ]
        ], 200);
    }
    public function getUserProfile()
    {
        $user = auth()->user();

        return response()->json([
            'user' => $user,
            'profile_image' => Storage::url($user->profile_image), // Retourne l'URL publique de l'image
        ]);
    }
}
