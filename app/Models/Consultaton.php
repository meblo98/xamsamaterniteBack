<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultaton extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function sageFemme()
    {
        return $this->belongsTo(SageFemme::class);
    }
    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }
}
