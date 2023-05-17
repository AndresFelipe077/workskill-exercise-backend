<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    use HasFactory;

    public function casa()
    {
        return $this->belongsTo(Casa::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

}
