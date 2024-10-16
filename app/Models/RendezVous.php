<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RendezVous extends Model
{
    use HasFactory;
    protected $table = 'rendez_vouses';
    protected $guarded = [];


    public function sageFemme()
    {
        return $this->belongsTo(SageFemme::class);
    }


    public function grossesse()
    {
        return $this->belongsTo(Grossesse::class);
    }

    public function consultation()
    {
        return $this->hasOne(Consultaton::class);
    }
}

