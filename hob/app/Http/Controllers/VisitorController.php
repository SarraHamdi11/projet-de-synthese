<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $latestLogements = []; // Empty array for now - fix undefined variable
        return view('visitor', compact('latestLogements'));
    }
}
