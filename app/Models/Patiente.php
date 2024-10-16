<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patiente extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Relation avec le modèle User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le modèle SageFemme.
     */
    public function sageFemme()
    {
        return $this->belongsTo(SageFemme::class);
    }
    public function grossesses()
    {
        return $this->hasMany(Grossesse::class);
    }
    public function badiene()
    {
        return $this->belongsTo(BadienGox::class, 'badien_gox_id');
    }
}
