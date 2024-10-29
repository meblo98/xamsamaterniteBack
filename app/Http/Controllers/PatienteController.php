<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use Twilio\Rest\Client;
use App\Models\Patiente;
use App\Mail\PatienteRegistered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StorePatienteRequest;
use App\Http\Requests\UpdatePatienteRequest;

class PatienteController extends Controller
{

    public function index()
{
    $user = Auth::user(); // Récupère l'utilisateur connecté

    if ($user->hasRole('sage-femme')) {
        $sageFemmeId = $user->sageFemme->id; // Récupère l'id de la sage-femme associée à l'utilisateur
        $patientes = Patiente::where('sage_femme_id', $sageFemmeId)->with('user')->get();
    } elseif ($user->hasRole('badiene-gox')) {
        $badieneId = $user->badienGox->id; // Récupère l'id de la badiene associée à l'utilisateur
        $patientes = Patiente::where('badien_gox_id', $badieneId)->with('user')->get();
    }elseif ($user->hasRole('admin')) {
        $patientes = Patiente::all()->with('user')->get();
    }
    else {
        $patientes = collect(); // Return an empty collection
    }

    return response()->json([
        'Liste_des_patientes' => $patientes,
    ]);
}


// Méthode pour créer une patiente
public function store(StorePatienteRequest $request)
{
    // Générer un mot de passe aléatoire
    $password = $this->generateRandomPassword();
    $user = Auth::user();
    $sageFemmeId = $user->sageFemme->id;
    try {
        $patiente = \DB::transaction(function () use ($request, $password, $sageFemmeId) {
            // Création de l'utilisateur
            $user = User::create([
                'prenom' => $request->prenom,
                'nom' => $request->nom,
                'adresse' => $request->adresse,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'password' => Hash::make($password),
            ]);

            // Assigner le rôle patiente via Spatie
            $user->assignRole('patiente');

            // Création de la patiente
            $patiente = Patiente::create([
                'user_id' => $user->id,
                'lieu_de_naissance' => $request->lieu_de_naissance,
                'date_de_naissance' => $request->date_de_naissance,
                'profession' => $request->profession,
                'sage_femme_id' => $sageFemmeId,
                'badien_gox_id' => $request->badien_gox_id,
            ]);

            // Envoi de l'email
            if ($user->email) {
                Mail::to($user->email)->send(new PatienteRegistered($user, $password));
            }
            // Envoyer le SMS avec le mot de passe
            // $this->sendSms($user->telephone, $password);

            return $patiente;
        });

        return response()->json([
            'message' => 'Patiente créée avec succès',
            'patiente' => $patiente,
            'mot de passe' => $password,
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erreur lors de la création de la patiente',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    // Fonction pour générer un mot de passe aléatoire
    private function generateRandomPassword($length = 8)
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
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

    // Méthode pour afficher une patiente
    public function show($id)
    {
        $patiente = Patiente::with('user')
            ->with('grossesses')
            
            ->findOrFail($id);

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
            'badien_gox_id' => $request->badien_gox_id,
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
    public function getPatientesByBadieneGox($badieneGoxId)
{
    // Vérifiez si l'utilisateur a le rôle de 'badiene-gox'
    $user = Auth::user();
    if (!$user) {
        return response()->json([
            'message' => 'Accès non autorisé',
        ], 403);
    }

    // Récupérer les patientes associées à la badiene gox par ID
    $patientes = Patiente::where('badien_gox_id', $badieneGoxId)->with('user')->get();

    return response()->json([
        'Liste_des_patientes' => $patientes,
    ]);
}
}
