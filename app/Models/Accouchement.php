<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accouchement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function patiente()
    {
        return $this->belongsTo(Patiente::class);
    }
    public function enfants()
    {
        return $this->hasMany(Enfant::class);
    }
}
