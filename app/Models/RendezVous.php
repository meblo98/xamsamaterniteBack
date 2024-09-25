<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RendezVous extends Model
{
    use HasFactory;
    protected $table = 'rendez_vouses';
    protected $guarded = [];

    public function patiente()
    {
        return $this->belongsTo(Patiente::class);
    }

    public function sageFemme()
    {
        return $this->belongsTo(SageFemme::class);
    }

    public function visite()
    {
        return $this->belongsTo(Visite::class);
    }

    public function vaccination()
    {
        return $this->belongsTo(Vaccination::class);
    }
}
