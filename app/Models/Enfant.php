<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function accouchement()
    {
        return $this->belongsTo(Accouchement::class);
    }
    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }
}
