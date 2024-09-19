<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;
use Carbon\Carbon;
use App\Models\RendezVous;

class RappelSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rappel-sms';

    protected $description = 'Envoi de SMS de rappel aux patients dont le rendez-vous est prévu le lendemain';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tomorrow = Carbon::now()->addDay()->toDateString();

        $rendezVous = RendezVous::whereDate('date_rv', $tomorrow)->with('patiente.user')->get();

        foreach ($rendezVous as $rv) {
            $patiente = $rv->patiente->user;
            $this->sendSms($patiente->user->telephone, "Bonjour, n'oubliez pas votre rendez-vous demain à {$rv->date_rv}.");
        }

        $this->info('Les rappels ont été envoyés avec succès !');
    }

    private function sendSms($to, $message)
    {
        $accountSid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');

        $client = new Client($accountSid, $authToken);
        
        try {
            $client->messages->create(
                $to,
                [
                    'from' => $twilioNumber,
                    'body' => $message,
                ]
            );
        } catch (\Exception $e) {
            $this->error('Envoi du SMS a échoué : ' . $e->getMessage());
        }
    }
}
