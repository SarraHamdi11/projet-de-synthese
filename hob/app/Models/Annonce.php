<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre_anno',
        'description_anno',
        'statut_anno',
        'date_publication_anno',
        'logement_id',
        'proprietaire_id',
    ];

    public function logement()
    {
        return $this->belongsTo(Logement::class, 'logement_id');
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function favori()
    {
        return $this->hasMany(Favori::class);
    }

    public function locataireDetails()
    {
        return $this->hasOne(AnnonceLocataire::class, 'annonce_id');
    }
}