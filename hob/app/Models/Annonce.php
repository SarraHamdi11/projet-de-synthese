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
        protected $table = 'annonces';
    protected $primaryKey = 'id';
    protected $casts = [
    'date_publication_anno' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];
 // Cast date_publication_anno to Carbon instance
    protected $dates = ['date_publication_anno', 'created_at', 'updated_at'];
  
    public function proprietaire()
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id', 'id');
    }

  
     public function logement()
    {
        return $this->belongsTo(Logement::class, 'logement_id', 'id');
    }

     public function utilisateurs()
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id', 'id');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'annonce_id', 'id');
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