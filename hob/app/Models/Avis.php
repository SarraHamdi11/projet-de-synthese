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
        $this->belongsTo(Annonce::class);
    }
    public function Utilisateur (){
        $this->belongsTo(Utilisateur::class);
    }
}
