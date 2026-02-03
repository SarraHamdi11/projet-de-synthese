<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_debut_res', 'date_fin_res', 'statut_res',
        'locataire_id', 'proprietaire_id', 'logements_id'
    ];
     protected $casts = [
        'date_debut_res' => 'datetime',
        'date_fin_res' => 'datetime',
    ];

    public function locataire()
        {
            return $this->belongsTo(Utilisateur::class, 'locataire_id');
        }

    public function proprietaire()
        {
            return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
        }

    public function logement()
    {
        return $this->belongsTo(Logement::class, 'logements_id');
    }

    public function logements()
    {
        return $this->belongsTo(Logement::class, 'logements_id');
    }
}
