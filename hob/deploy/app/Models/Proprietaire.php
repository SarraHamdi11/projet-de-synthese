<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Proprietaire extends Utilisateur
{
    use HasFactory ;
    protected static function booted()
    {
        static::addGlobalScope('proprietaires', function ($query) {
            $query->where('role_uti', 'proprietaire');
        });
    }
}
