<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conseil extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sageFemme()
    {
        return $this->belongsTo(SageFemme::class);
    }

    public function grossesse()
    {
        return $this->belongsTo(Patiente::class);
    }
}
