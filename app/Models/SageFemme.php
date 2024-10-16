<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SageFemme extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
{
    return $this->belongsTo(User::class);
}
public function grossesses()
{
    return $this->hasMany(Grossesse::class);
}
public function structureSante()
{
    return $this->belongsTo(StructureSante::class);
}
}
