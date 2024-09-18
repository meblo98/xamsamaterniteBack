<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Générer un mot de passe aléatoire
        $password = 'passer123';

        // Créer un utilisateur admin
        $user = User::create([
            'prenom' => 'Admin',
            'nom' => 'Super',
            'adresse' => 'Dakar, Sénégal',
            'email' => 'admin1@example.com',
            'telephone' => '780000000',
            'password' => Hash::make($password),
        ]);

        // Assigner le rôle admin via Spatie
        $user->assignRole('admin');

        // Créer un profil admin lié à l'utilisateur
        Admin::create([
            'user_id' => $user->id,
        ]);

        // // Envoyer le SMS avec le mot de passe
        // $this->sendSms($user->telephone, $password);
    }

    // Fonction pour générer un mot de passe aléatoire
    private function generateRandomPassword($length = 8)
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

    // // Fonction pour envoyer un SMS via Twilio
    // private function sendSms($telephone, $password)
    // {
    //     $sid = env('TWILIO_SID');
    //     $token = env('TWILIO_TOKEN');
    //     $twilio = new Client($sid, $token);

    //     $message = "Votre compte administrateur a été créé. Mot de passe : $password";

    //     $twilio->messages->create(
    //         '+221'.$telephone, // Ajouter le code pays du Sénégal
    //         [
    //             'from' => env('TWILIO_PHONE_NUMBER'),
    //             'body' => $message,
    //         ]
    //     );
    // }
}
