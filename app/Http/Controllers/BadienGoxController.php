<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use App\Models\BadienGox;
use Illuminate\Http\Response;
use App\Mail\BadieneGoxCreated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreBadienGoxRequest;
use App\Http\Requests\UpdateBadienGoxRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BadienGoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer l'ID de la sage-femme associée à cet utilisateur
        $sageFemmeId = $user->sageFemme->id;

        // Récupérer les Badiene Gox associées à cette sage-femme avec les informations de l'utilisateur
        $badieneGoxes = BadienGox::where('sage_femme_id', $sageFemmeId)->with('user')->get();

        return response()->json([
            'Liste des Badiene Gox' => $badieneGoxes,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // Ajouter une nouvelle Badiene Gox
    public function store(StoreBadienGoxRequest $request)
    {
        // Générer un mot de passe aléatoire
        $password = $this->generateRandomPassword();
        $user = Auth::user();
        $sageFemmeId = $user->sageFemme->id;

        // Créer un utilisateur d'abord
        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'password' => Hash::make($password),
        ]);

        // Créer la Badiene Gox en associant l'utilisateur créé
        $badieneGox = BadienGox::create([
            'user_id' => $user->id,
            'sage_femme_id' => $sageFemmeId,
            'adresse' => $request->adresse,
        ]);

        // Envoi de l'email
        Mail::to($user->email)->send(new BadieneGoxCreated($badieneGox, $password));

        // Envoi du SMS via Twilio
        // $this->sendSmsNotification($user->telephone, $password);

        return response()->json($badieneGox, Response::HTTP_CREATED);
    }

    // Fonction pour générer un mot de passe aléatoire
    private function generateRandomPassword($length = 8)
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

    // Méthode pour envoyer un SMS via Twilio
    private function sendSmsNotification($password, $telephone)
    {
        $sid = config('twilio.sid');
        $token = config('twilio.token');
        $twilio = new Client($sid, $token);

        $client = new Client($sid, $password);

        $message = "Nouvelle Badiene Gox ajoutée : veillez saissir votre telephone ou votre email pour vous connecter, Mot de passe: ". $password;

        $client->messages->create('+221'.$telephone, [
            'from' => env('TWILIO_PHONE_NUMBER'),
            'body' => $message
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BadienGox $badienGox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BadienGox $badienGox)
    {
        //
    }

 /**
 * Update the specified resource in storage.
 */
public function update(UpdateBadienGoxRequest $request, $id)
{
    // Trouver la Badiene Gox ou retourner une erreur 404 si non trouvée
    $badieneGox = BadienGox::findOrFail($id);

    // Trouver l'utilisateur associé à la Badiene Gox
    $user = User::findOrFail($badieneGox->user_id);

    // Commencez une transaction pour garantir que toutes les mises à jour réussissent ensemble
    DB::beginTransaction();

    try {
        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'adresse' => $request->input('adresse'),
            'telephone' => $request->input('telephone'),
        ]);

        // Mettre à jour les informations de la Badiene Gox
        $badieneGox->update([
            'adresse' => $request->input('adresse'),
        ]);

        // Confirmer la transaction
        DB::commit();

        // Retourner la réponse avec succès
        return response()->json([
            'message' => 'Badiene Gox mise à jour avec succès',
            'badiene_gox' => $badieneGox,
            'user' => $user
        ], Response::HTTP_OK);
    } catch (\Exception $e) {
        // Annuler la transaction en cas d'erreur
        DB::rollBack();

        // Retourner une réponse d'erreur
        return response()->json([
            'message' => 'Échec de la mise à jour de la Badiene Gox',
            'error' => $e->getMessage()
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Récupérer la Badiene Gox via son ID
            $badieneGox = BadienGox::findOrFail($id);

            // Récupérer l'utilisateur associé avant la suppression
            $user = User::findOrFail($badieneGox->user_id);

            // Supprimer la Badiene Gox (ce qui supprimera également l'utilisateur grâce à la suppression en cascade)
            $badieneGox->delete();

            // Envoyer une réponse de succès
            return response()->json([
                'message' => 'Badiene Gox et utilisateur associés supprimés avec succès'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Gérer les erreurs éventuelles
            return response()->json([
                'message' => 'Erreur lors de la suppression de la Badiene Gox',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
