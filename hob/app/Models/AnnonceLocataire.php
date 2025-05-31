<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnnonceLocataire extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'proprietaire_id',
        'budget',
        'ville',
        'nombre_colocataire_log',
        'type_log',
        'description',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
}