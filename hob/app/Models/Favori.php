<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Favori extends Model
{ 
    use HasFactory ;
    protected $fillable = [
        'date_d_ajout_fav','locataire_id','annonce_id'
    ];
    public function annonce (){
        $this->belongsTo(Annonce::class);
    }
    public function Utilisateur (){
        $this->belongsTo(Utilisateur::class);
    }
}
