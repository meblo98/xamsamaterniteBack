<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use App\Models\SageFemme;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SageFemmeRegistered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreSageFemmeRequest;
use App\Http\Requests\UpdateSageFemmeRequest;
use App\Http\Requests\ArchiveSageFemmeRequest;

class SageFemmeController extends Controller
{


public function store(Request $request)
{
    // Valider les données
    $validator = Validator::make($request->all(), [
        'prenom' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email', // Vérifie l'unicité de l'email
        'telephone' => 'required|unique:users,telephone', // Vérifie l'unicité du téléphone
        'adresse' => 'required|string|max:255',
        'structure_sante_id' => 'required|exists:structure_santes,id', // Assurez-vous que cette table et cet ID existent
        'matricule' => 'required|string|max:255|unique:sage_femmes,matricule', // Unicité du matricule
    ]);

    // Si la validation échoue, renvoyer une réponse avec un message d'erreur
    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    // Générer un mot de passe aléatoire
    $password = Str::random(12);

    // Création de l'utilisateur
    $user = User::create([
        'prenom' => $request->prenom,
        'nom' => $request->nom,
        'email' => $request->email,
        'telephone' => $request->telephone,
        'adresse' => $request->adresse,
        'photo' => $request->photo,
        'password' => Hash::make($password),
    ]);

    // Assigner le rôle sage-femme via Spatie
    $user->assignRole('sage-femme');

    // Création de la sage-femme
    $sageFemme = SageFemme::create([
        'user_id' => $user->id,
        'structure_sante_id' => $request->structure_sante_id,
        'matricule' => $request->matricule,
        'archived' => false, // Définir par défaut
    ]);

    // Envoyer le SMS avec le mot de passe
    // $this->sendSms($user->telephone, $password);

    // Envoi d'un e-mail de confirmation
    Mail::to($user->email)->send(new SageFemmeRegistered($user, $password));

    return response()->json([
        'message' => 'Sage-femme ajoutée avec succès',
        'sage_femme' => $user,$sageFemme,
    ], 201);
}


    // Fonction pour envoyer un SMS via Twilio
    // private function sendSms($telephone, $password)
    // {
    //     $sid = env('TWILIO_SID');
    //     $token = env('TWILIO_TOKEN');
    //     $twilio = new Client($sid, $token);

    //     $message = "Votre compte a été créé. Mot de passe : $password";

    //     $twilio->messages->create(
    //         '+221' . $telephone, // Ajouter le code pays du Sénégal
    //         [
    //             'from' => env('TWILIO_PHONE_NUMBER'),
    //             'body' => $message,
    //         ]
    //     );
    // }


    public function show($id)
    {
        try {
            // Récupérer la sage-femme par ID
            $sageFemme = SageFemme::with('user')->findOrFail($id);

            // Retourner les détails en réponse JSON
            return response()->json([
                'sage_femme' => $sageFemme,
            ], 200);
        } catch (\Exception $e) {
            // Log des erreurs et retour d'une réponse d'erreur
            Log::error('Erreur lors de la récupération de la sage-femme: ' . $e->getMessage());
            return response()->json([
                'error' => 'Sage-femme non trouvée.',
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        // Trouver la sage-femme à mettre à jour
        $sageFemme = SageFemme::findOrFail($id);
    
        // Extraire l'ID de l'utilisateur lié à la sage-femme
        $userId = $sageFemme->user_id;
    
        // Valider les données de la requête
        $validatedData = $request->validate([
            'prenom' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $userId,
            'telephone' => 'sometimes|string|unique:users,telephone,' . $userId,
            'adresse' => 'nullable|string',
            'photo' => 'nullable|string',
            'matricule' => 'sometimes|string',
            'password' => 'sometimes|string',
            'structure_sante_id' => 'sometimes|exists:structure_santes,id',
        ]);
    
        // Mise à jour des détails de l'utilisateur
        $sageFemme->user->update($request->only(['prenom', 'nom', 'email', 'telephone', 'adresse', 'photo','password']));
    
        // Mise à jour des détails de la sage-femme
        $sageFemme->update($request->only(['matricule', 'structure_sante_id']));
    
        return response()->json([
            'message' => 'Sage-femme mise à jour avec succès',
            'sage_femme' => $sageFemme
        ], 200);
    }
    

    public function destroy($id)
    {
        // Trouver la sage-femme
        $sageFemme = SageFemme::findOrFail($id);

        // Supprimer la sage-femme
        $sageFemme->delete();

        // Supprimer l'utilisateur associé
        $sageFemme->user->delete();

        return response()->json(['message' => 'Sage-femme supprimée avec succès'], 200);
    }

    public function archive(ArchiveSageFemmeRequest $request, $id)
    {

        // Trouver la sage-femme
        $sageFemme = SageFemme::findOrFail($id);

        // Archiver la sage-femme
        $sageFemme->archived = $request->archived;
        $sageFemme->save();

        return response()->json(['message' => 'Sage-femme archivée avec succès'], 200);
    }

    public function index()
    {
        // Récupérer toutes les sages-femmes non archivées
        $sagesFemmes = SageFemme::where('archived', false)->with('structureSante','user')->get();

        return response()->json([
            'sages_femmes' => $sagesFemmes
        ], 200);
    }
}
