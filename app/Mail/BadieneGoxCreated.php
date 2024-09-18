<?php

namespace App\Mail;

use App\Models\BadienGox;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BadieneGoxCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $badieneGox;
    public $password;

    public function __construct($badieneGox, $password)
    {
        $this->badieneGox = $badieneGox;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Nouvelle Badiene Gox Créée')
                    ->view('emails.badiene_gox_created')
                    ->with([
                        'badieneGox' => $this->badieneGox,
                        'password' => $this->password,
                    ]);
    }
}
