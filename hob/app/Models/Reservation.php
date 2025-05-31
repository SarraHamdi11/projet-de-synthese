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

    public function locataire()
        {
            return $this->belongsTo(Utilisateur::class, 'locataire_id');
        }

    public function proprietaire()
        {
            return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
        }

    public function logments()
        {
            return $this->belongsTo(Logement::class);
        }


}
