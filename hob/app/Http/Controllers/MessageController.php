<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;
use App\Events\MessageRead;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all conversations where user is either sender or receiver
        $conversations = Conversation::where('expediteur_id', $user->id)
            ->orWhere('destinataire_id', $user->id)
            ->with(['expediteur', 'destinataire', 'messages' => function($query) {
                $query->latest()->first();
            }])
            ->latest('date_debut_conv')
            ->get();

        return view('messages.index', compact('conversations'));
    }

    public function show($receiverId)
    {
        $receiver = Utilisateur::findOrFail($receiverId);
        $messages = Message::where(function($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $receiverId);
        })->orWhere(function($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        Message::where('sender_id', $receiverId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        // Broadcast read status
        event(new MessageRead(Auth::id(), $receiverId));

        return view('messages.show', compact('messages', 'receiver'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:utilisateurs,id',
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'contenu_msg' => $request->message,
            'date_envoi_msg' => now(),
            'is_read' => false,
        ]);

        // Broadcast new message event
        event(new NewMessage($message));

        return back()->with('success', 'Message envoyé');
    }

    public function viewConversation($id)
    {
        return $this->show($id);
    }

    public function deleteConversation($id)
    {
        $conversation = Conversation::findOrFail($id);
        
        if ($conversation->expediteur_id !== Auth::id() && $conversation->destinataire_id !== Auth::id()) {
            return back()->with('error', 'Accès non autorisé');
        }

        $conversation->delete();
        
        return redirect()->route('messages.index')->with('success', 'Conversation supprimée');
    }

    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);
        
        if ($message->sender_id !== Auth::id()) {
            return back()->with('error', 'Accès non autorisé');
        }

        $message->delete();
        
        return back()->with('success', 'Message supprimé');
    }
        foreach ($messages as $message) {
            if ($message->sender_id === Auth::id()) {
                broadcast(new MessageRead($message))->toOthers();
            }
        }

        return view('messages.show', compact('messages', 'receiver'));
    }

    public function fetch($receiverId)
    {
        $messages = Message::where(function($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $receiverId);
        })->orWhere(function($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:utilisateurs,id',
            'message_type' => 'required|in:text,image,file',
            'attachments' => 'nullable|array'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'message_type' => $request->message_type,
            'attachments' => $request->attachments,
            'is_read' => false
        ]);

        // Update conversation's last message timestamp
        Conversation::where(function($query) use ($request) {
            $query->where('expediteur_id', Auth::id())
                  ->where('destinataire_id', $request->receiver_id);
        })->orWhere(function($query) use ($request) {
            $query->where('expediteur_id', $request->receiver_id)
                  ->where('destinataire_id', Auth::id());
        })->update(['date_debut_conv' => now()]);

        // Broadcast the new message
        broadcast(new NewMessage($message))->toOthers();

        // Send notification to receiver
        $receiver = Utilisateur::find($request->receiver_id);
        $receiver->notify(new \App\Notifications\NewMessageNotification($message));

        return response()->json($message);
    }

    public function markAsRead(Message $message)
    {
        if ($message->receiver_id === Auth::id()) {
            $message->update([
                'is_read' => true,
                'read_at' => now()
            ]);

            broadcast(new MessageRead($message))->toOthers();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    public function delete(Message $message)
    {
        if ($message->sender_id === Auth::id()) {
            $message->update([
                'is_deleted' => true,
                'deleted_at' => now()
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    public function send(Request $request)
    {
        try {
            $request->validate([
                'receiver_id' => 'required|exists:utilisateurs,id',
                'message' => 'required|string|max:1000',
            ]);

            // Find or create the conversation
            $conversation = Conversation::where(function($q) use ($request) {
                $q->where('expediteur_id', auth()->id())
                  ->where('destinataire_id', $request->receiver_id);
            })->orWhere(function($q) use ($request) {
                $q->where('expediteur_id', $request->receiver_id)
                  ->where('destinataire_id', auth()->id());
            })->first();

            if (!$conversation) {
                $conversation = Conversation::create([
                    'expediteur_id' => auth()->id(),
                    'destinataire_id' => $request->receiver_id,
                    'date_debut_conv' => now()
                ]);
            }

            // Save the message
            $message = $conversation->messages()->create([
                'sender_id' => auth()->id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'message_type' => 'text',
                'is_read' => false,
            ]);

            return response()->json([
                'success' => true,
                'conversation_id' => $conversation->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
} 