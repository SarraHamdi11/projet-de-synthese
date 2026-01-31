<?php

namespace App\Http\Controllers\Proprietaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProprietaireProfileController extends Controller
{
    /**
     * Display the landlord profile page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Using hardcoded data since we don't have database setup yet
        $proprietaire = (object)[
            'id' => 1,
            'nom' => 'Ahmed Bekaoui',
            'prenom' => 'Ahmed',
            'telephone' => '+212 123456789',
            'email' => 'ahmed.bekaoui@gmail.com',
            'role' => 'locataire',
            'ville' => 'Martil',
            'date_naissance' => '2002/08/17'
        ];
        
        // Hardcoded counts
        $annoncesCount = 10;
        $commentairesCount = 30;
        
        // Hardcoded announcements
        $annonces = [
            [
                'id' => 1,
                'titre' => 'Appartement cosy à Rabat',
                'description' => 'Découvrez cette magnifique maison située au cœur du quartier prisé d\'Agdal à Rabat. Offrant un cadre de vie paisible et élégant.',
                'image' => 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg',
                'date_publication' => '19 Avril 2024',
                'commentaires_count' => 30,
            ],
            [
                'id' => 2,
                'titre' => 'Appartement cosy à Fès',
                'description' => 'Découvrez cette magnifique maison contemporaine située dans un quartier résidentiel calme et sécurisé de Fès.',
                'image' => 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg',
                'date_publication' => '1 Avril 2024',
                'commentaires_count' => 10,
            ],
            [
                'id' => 2,
                'titre' => 'Appartement cosy à Fès',
                'description' => 'Découvrez cette magnifique maison contemporaine située dans un quartier résidentiel calme et sécurisé de Fès.',
                'image' => 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg',
                'date_publication' => '1 Avril 2024',
                'commentaires_count' => 10,
            ],
            [
                'id' => 2,
                'titre' => 'Appartement cosy à Fès',
                'description' => 'Découvrez cette magnifique maison contemporaine située dans un quartier résidentiel calme et sécurisé de Fès.',
                'image' => 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg',
                'date_publication' => '1 Avril 2024',
                'commentaires_count' => 10,
            ],
            [
                'id' => 2,
                'titre' => 'Appartement cosy à Fès',
                'description' => 'Découvrez cette magnifique maison contemporaine située dans un quartier résidentiel calme et sécurisé de Fès.',
                'image' => 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg',
                'date_publication' => '1 Avril 2024',
                'commentaires_count' => 10,
            ],
            [
                'id' => 2,
                'titre' => 'Appartement cosy à Fès',
                'description' => 'Découvrez cette magnifique maison contemporaine située dans un quartier résidentiel calme et sécurisé de Fès.',
                'image' => 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg',
                'date_publication' => '1 Avril 2024',
                'commentaires_count' => 10,
            ],
        ];
        
        return view('proprietaire.profile', compact('proprietaire', 'annoncesCount', 'commentairesCount', 'annonces'));
    }

    public function myProfile()
    {
        $proprietaire = Auth::user();
        $annonces = \App\Models\Annonce::where('proprietaire_id', $proprietaire->id)->get();
        $annoncesCount = $annonces->count();
        $commentairesCount = \App\Models\Avis::whereIn('annonce_id', $annonces->pluck('id'))->count();
        return view('proprietaire.myprofile', compact('proprietaire', 'annoncesCount', 'commentairesCount', 'annonces'));
    }
}