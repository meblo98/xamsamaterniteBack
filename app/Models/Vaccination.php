<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function enfant()
    {
        return $this->belongsTo(Enfant::class);
    }
}
