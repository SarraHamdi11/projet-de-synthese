<?php

namespace App\Http\Controllers\locataire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Utilisateur;
use App\Models\Avis;

class LocataireProfileController extends Controller
{
    public function show($id)
    {
        $locataire = Utilisateur::findOrFail($id);
        $avis = Avis::where('locataire_id', $id)->get();
        return view('profile', compact('locataire', 'avis'));
    }

    public function myProfile()
    {
        $locataire = Auth::user();
        $avis = \App\Models\Avis::where('locataire_id', $locataire->id)->get();
        return view('locataire.myprofile', compact('locataire', 'avis'));
    }
}