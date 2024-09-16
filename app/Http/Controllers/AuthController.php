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
            'login' => 'string|required', // Peut être email ou numéro de téléphone
            'password' => 'string|required',
        ]);
    
        // Identifier si 'login' est un email ou un numéro de téléphone
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        // Créer les identifiants pour la tentative de connexion
        $credentials = [
            $loginField => $request->login,
            'password' => $request->password
        ];
        
    
        // Tenter de se connecter
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        return $this->respondWithToken($token);
    }
    

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    
    // public function register(Request $request)
    // {
    //     // Validation des champs
    //     $validator = Validator::make($request->all(), [
    //         // les règles de validation...
    //     ]);
    
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }
    
    //     // Création de l'utilisateur principal
    //     $user = User::create([
    //         'prenom' => $request->prenom,
    //         'nom' => $request->nom,
    //         'adresse' => $request->adresse,
    //         'email' => $request->email,
    //         'telephone' => $request->telephone,
    //         'password' => Hash::make('passer123'), // Mot de passe par défaut
    //     ]);
    
    //     // Association du profil en fonction du type choisi
    //     switch ($request->type_profil) {
    //         case 'admin':
    //             Admin::create(['user_id' => $user->id]);
    //             $user->assignRole('admin');
    //             break;
    //         case 'sage-femme':
    //             SageFemme::create([
    //                 'user_id' => $user->id,
    //                 'structure_sante_id' => $request->structure_sante_id,
    //                 'matricule' => $request->matricule,
    //             ]);
    //             $user->assignRole('sage-femme');
    //             break;
    //         case 'patiente':
    //             Patiente::create([
    //                 'user_id' => $user->id,
    //                 'lieu_de_naissance' => $request->lieu_de_naissance,
    //                 'date_de_naissance' => $request->date_de_naissance,
    //                 'profession' => $request->profession,
    //                 'type' => $request->type ?? 'Enceinte',
    //             ]);
    //             $user->assignRole('patiente');
    //             break;
    //         case 'badiene-gox':
    //             BadienGox::create([
    //                 'user_id' => $user->id,
    //                 'adresse' => $request->adresse,
    //                 'sage_femme_id' => $request->sage_femme_id,
    //             ]);
    //             $user->assignRole('badiene-gox');
    //             break;
    //         default:
    //             return response()->json(['error' => 'Type de profil non valide'], 400);
    //     }
    
    //     // Envoi de l'email de bienvenue
    //     $user->notify(new UserRegistered($user));
    
    //     // Envoi du SMS de bienvenue
    //     $this->sendSms($user->telephone, 'Bienvenue ' . $user->prenom . '! Votre compte a été créé avec succès.');
    
    //     // Retourner la réponse de succès
    //     return response()->json([
    //         'message' => 'Utilisateur enregistré avec succès et notifications envoyées',
    //         'user' => $user,
    //     ], 201);
    // }
    
    // function sendSms($to, $message)
    // {
    //     $sid = env('TWILIO_SID');
    //     $token = env('TWILIO_AUTH_TOKEN');
    //     $twilio = new Client($sid, $token);
    
    //     $twilio->messages->create($to, [
    //         'from' => env('TWILIO_NUMBER'),
    //         'body' => $message,
    //     ]);
    // }
    

}
