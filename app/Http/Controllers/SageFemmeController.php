<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSageFemmeRequest;
use App\Http\Requests\UpdateSageFemmeRequest;
use App\Http\Requests\ArchiveSageFemmeRequest;
use App\Mail\SageFemmeRegistered;
use App\Models\SageFemme;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class SageFemmeController extends Controller
{
    public function store(StoreSageFemmeRequest $request)
    {
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


        // Assigner le rôle admin via Spatie
        $user->assignRole('sage-femme');

        // Création de la sage-femme
        SageFemme::create([
            'user_id' => $user->id,
            'structure_sante_id' => $request->structure_sante_id,
            'matricule' => $request->matricule,
            'archived' => false, // Définir par défaut
        ]);

        // Envoyer le SMS avec le mot de passe
        $this->sendSms($user->telephone, $password);

        // Envoi d'un e-mail de confirmation
        Mail::to($user->email)->send(new SageFemmeRegistered($user, $password));



        return response()->json([
            'message' => 'Sage-femme ajoutée avec succès',
            'sage_femme' => $user,
            'mot de passe' => $password
        ], 201);
    }

    // Fonction pour envoyer un SMS via Twilio
    private function sendSms($telephone, $password)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);

        $message = "Votre compte a été créé. Mot de passe : $password";

        $twilio->messages->create(
            '+221' . $telephone, // Ajouter le code pays du Sénégal
            [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => $message,
            ]
        );
    }


    public function show($id)
    {
        try {
            // Récupérer la sage-femme par ID
            $sageFemme = SageFemme::findOrFail($id);

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


    public function update(UpdateSageFemmeRequest $request, $id)
    {

        // Trouver la sage-femme à mettre à jour
        $sageFemme = SageFemme::findOrFail($id);

        // Mise à jour des détails de l'utilisateur
        $sageFemme->user->update($request->only(['prenom', 'nom', 'email', 'telephone', 'adresse', 'photo']));

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
        $sagesFemmes = SageFemme::where('archived', false)->with('user')->get();

        return response()->json([
            'sages_femmes' => $sagesFemmes
        ], 200);
    }
}
