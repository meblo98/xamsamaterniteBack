<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grossesse extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function accouchement()
    {
        return $this->hasOne(Accouchement::class);
    }
    public function patiente()
    {
        return $this->belongsTo(Patiente::class);
    }
    public function sageFemme()
    {
        return $this->belongsTo(SageFemme::class);
    }
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }
    public function conseils()
    {
        return $this->hasMany(Conseil::class);
    }
}
