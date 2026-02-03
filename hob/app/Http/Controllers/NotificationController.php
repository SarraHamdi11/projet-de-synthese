<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);
            
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        if ($notification->user_id !== Auth::id()) {
            return back()->with('error', 'Accès non autorisé');
        }

        $notification->update(['read_at' => now()]);
        
        return back()->with('success', 'Notification marquée comme lue');
    }

    public function deleteAll()
    {
        Notification::where('user_id', Auth::id())->delete();
        
        return redirect()->route('notifications.index')->with('success', 'Toutes les notifications ont été supprimées');
    }
}
