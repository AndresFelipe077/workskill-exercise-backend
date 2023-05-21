<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casa extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function usuarios()
    {
        return $this->belongsToMany(User::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'idEstado');
    }

    public function estadoAlquiler()
    {
        return $this->belongsTo(EstadoAlquiler::class);
    }

    public function marcarComoAlquilada()
    {
        $this->estado = 'alquilada';
        $this->save();
    }
}
