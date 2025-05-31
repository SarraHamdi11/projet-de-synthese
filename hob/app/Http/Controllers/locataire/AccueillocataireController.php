<?php
namespace App\Http\Controllers\locataire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class AccueilLocataireController extends Controller
{
    public function index()
    {
        $unreadCount = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('locataire.accueillocataire', compact('unreadCount'));
    }
}
