<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accouchement extends Model
{
    use HasFactory;
    protected $guarded = [];

 
    public function enfants()
    {
        return $this->hasMany(Enfant::class);
    }
    public function grossesse()
    {
        return $this->belongsTo(Grossesse::class);
    }
}
