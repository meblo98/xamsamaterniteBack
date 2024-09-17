<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use App\Models\Patiente;
use App\Mail\PatienteRegistered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StorePatienteRequest;
use App\Http\Requests\UpdatePatienteRequest;

class PatienteController extends Controller
{

    public function index()
    {
        // Utilisation de with() avant get() pour charger la relation 'user'
        $patientes = Patiente::with('user')->get();

        return response()->json([
            'Liste des patientes' => $patientes,
        ]);
    }


    // Méthode pour créer une patiente
    public function store(StorePatienteRequest $request)
    {
          // Générer un mot de passe aléatoire
          $password = $this->generateRandomPassword();

        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($password),
        ]);

        // Assigner le rôle admin via Spatie
        $user->assignRole('patiente');

        // Création de la patiente
        $patiente = Patiente::create([
            'user_id' => $user->id,
            'lieu_de_naissance' => $request->lieu_de_naissance,
            'date_de_naissance' => $request->date_de_naissance,
            'profession' => $request->profession,
            'type' => $request->type,
            'sage_femme_id' => $request->sage_femme_id,
        ]);

        // Envoi de l'email
        Mail::to($user->email)->send(new PatienteRegistered($user, $request->password));

        // Envoi du SMS
        $this->sendSms($user->telephone, 'Votre compte a été créé. Votre mot de passe est : ' . $password);

        return response()->json([
            'message' => 'Patiente créée avec succès',
            'patiente' => $patiente,
        ], 201);
    }


      // Fonction pour générer un mot de passe aléatoire
      private function generateRandomPassword($length = 8)
      {
          return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
      }

    // Méthode pour envoyer un SMS
    private function sendSms($to, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilioNumber = env('TWILIO_NUMBER');

        $client = new Client($sid, $token);

        $client->messages->create(
            $to,
            [
                'from' => $twilioNumber,
                'body' => $message,
            ]
        );
    }

    // Méthode pour afficher une patiente
    public function show($id)
    {
        $patiente = Patiente::with('user')->findOrFail($id);

        return response()->json([
            'patiente' => $patiente,
        ]);
    }

    // Méthode pour mettre à jour une patiente
    public function update(UpdatePatienteRequest $request, $id)
    {
        $patiente = Patiente::findOrFail($id);

        $user = User::findOrFail($patiente->user_id);
        $user->update([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        $patiente->update([
            'lieu_de_naissance' => $request->lieu_de_naissance,
            'date_de_naissance' => $request->date_de_naissance,
            'profession' => $request->profession,
            'type' => $request->type,
        ]);

        return response()->json([
            'message' => 'Patiente mise à jour avec succès',
            'patiente' => $patiente,
        ]);
    }

    // Méthode pour supprimer une patiente
    public function destroy($id)
    {
        $patiente = Patiente::findOrFail($id);
        $user = User::findOrFail($patiente->user_id);

        $patiente->delete();
        $user->delete();

        return response()->json([
            'message' => 'Patiente supprimée avec succès',
        ]);
    }

    // Méthode pour archiver une patiente (ici, on ne fait que marquer comme inactive)
    public function archive($id)
    {
        $patiente = Patiente::findOrFail($id);
        $patiente->update(['archived' => true]);

        return response()->json([
            'message' => 'Patiente archivée avec succès',
        ]);
    }
}
