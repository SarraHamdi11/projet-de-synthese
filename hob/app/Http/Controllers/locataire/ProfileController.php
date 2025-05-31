<?php

   namespace App\Http\Controllers;

   use Illuminate\Http\Request;
   use Illuminate\Support\Collection;
    use App\Models\Utilisateur;
    use App\Models\Avis;
   class ProfileController extends Controller
   {
      
      public function show($id)
    {
        $locataire = Utilisateur::findOrFail($id);
        $avis = Avis::where('locataire_id', $id)->get(); // Requête manuelle au lieu d'utiliser la relation

        return view('profile', compact('locataire', 'avis'));
    }
   }