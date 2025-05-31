<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Statistique extends Model
{
    use HasFactory ;
    protected $fillable = [
        'nombre_utilisateur', 'nombre_annonce', 'note_moyenne_annonce',
        'nombre_reservation', 'nombre_reservation_annule',
        'nombre_reservation_accepter', 'nombre_reservation_en_attente',
        'note_moyenne_utilisateur'
    ];
    
}
