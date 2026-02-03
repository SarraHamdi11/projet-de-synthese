<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $latestLogements = []; // Empty array for now - fix undefined variable
        $avis = []; // Empty array for reviews/testimonials
        $statsData = [
            'nombre_reservation' => 0,
            'note_moyenne_annonce' => 0,
            'nombre_utilisateur' => 0
        ]; // Empty stats data
        return view('visitor', compact('latestLogements', 'avis', 'statsData'));
    }
}
