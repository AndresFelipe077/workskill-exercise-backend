<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casa extends Model
{
    use HasFactory;


    public function usuarios()
    {
        return $this->belongsToMany(User::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function estadoAlquiler()
    {
        return $this->belongsTo(EstadoAlquiler::class);
    }


}
