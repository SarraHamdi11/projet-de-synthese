<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Avis extends Model
{
    use HasFactory ;
    protected $fillable = [
        'contenu', 'note', 'annonce_id', 'locataire_id'

    ];
    
    
    protected $table = 'avis';
    protected $primaryKey = 'id';

   
    public function Utilisateur (){
        $this->belongsTo(Utilisateur::class);
    }
    
    // Relationship with Utilisateur (locataire)
     public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonce_id', 'id');
    }

    // Relationship with Utilisateur (locataire)
    public function locataire()
    {
        return $this->belongsTo(Utilisateur::class, 'locataire_id', 'id');
    }
}
