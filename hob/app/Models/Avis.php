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
    public function annonce (){
        return $this->belongsTo(Annonce::class, 'annonce_id');
    }
    public function utilisateur (){
        return $this->belongsTo(Utilisateur::class, 'locataire_id');
    }
}
