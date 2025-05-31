<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Utilisateur;

class ConversationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = Conversation::where('expediteur_id', $user->id)
            ->orWhere('destinataire_id', $user->id)
            ->with(['expediteur', 'destinataire'])
            ->latest('date_debut_conv')
            ->get();

        return view('conversations.index', compact('conversations'));
    }

    // Show or create a conversation between the authenticated user and the proprietaire
    public function showOrCreate($proprietaireId)
    {
        $user = Auth::user();
        $proprietaire = Utilisateur::findOrFail($proprietaireId);

        // Find existing conversation
        $conversation = Conversation::where(function($query) use ($user, $proprietaire) {
            $query->where('expediteur_id', $user->id)
                  ->where('destinataire_id', $proprietaire->id);
        })->orWhere(function($query) use ($user, $proprietaire) {
            $query->where('expediteur_id', $proprietaire->id)
                  ->where('destinataire_id', $user->id);
        })->first();

        // Create new conversation if none exists
        if (!$conversation) {
            $conversation = Conversation::create([
                'expediteur_id' => $user->id,
                'destinataire_id' => $proprietaire->id,
                'date_debut_conv' => now()
            ]);
        }

        // Get messages between the two users
        $messages = $conversation->allMessages();

        return view('conversations.show', compact('conversation', 'messages', 'proprietaire'));
    }

    // View a conversation by its ID
    public function view($id)
    {
        $conversation = Conversation::with(['expediteur', 'destinataire'])->findOrFail($id);

        if (Auth::id() !== $conversation->expediteur_id && Auth::id() !== $conversation->destinataire_id) {
            abort(403);
        }

        $messages = $conversation->allMessages();
        Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $currentUserId = Auth::id();
        $otherUser = $conversation->expediteur_id == $currentUserId
            ? $conversation->destinataire
            : $conversation->expediteur;

        // Always return only the modal partial, never the full layout
        return view('conversations._modal', compact('conversation', 'messages', 'otherUser'));
    }

    public function delete($id)
    {
        $conversation = Conversation::findOrFail($id);
        if (Auth::id() !== $conversation->expediteur_id && Auth::id() !== $conversation->destinataire_id) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }
        $conversation->delete();
        return response()->json(['success' => true]);
    }
} 