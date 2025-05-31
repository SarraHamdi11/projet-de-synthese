<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Logement extends Model
{
    use HasFactory ; 
    protected $fillable = [
        'prix_log','localisation_log', 'date_creation_log',
        'type_log','equipements', 'photos',
        'etage', 'nombre_colocataire_log',
        'ville', 'views', 'proprietaire_id'
    ];
    protected $casts = [
        'equipements' => 'array',
        'photos' => 'array', // باش Laravel يعرف بلي photos هو array
    ];

    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
    public function Annonce(){
        return $this->hasMany(Annonce::class, 'logement_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proprietaire()
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
    }
}
