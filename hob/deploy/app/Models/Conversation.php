<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'expediteur_id',
        'destinataire_id',
        'date_debut_conv'
    ];

    protected $casts = [
        'date_debut_conv' => 'datetime'
    ];

    public function allMessages()
    {
        return Message::where(function($query) {
            $query->where('sender_id', $this->expediteur_id)
                  ->where('receiver_id', $this->destinataire_id);
        })->orWhere(function($query) {
            $query->where('sender_id', $this->destinataire_id)
                  ->where('receiver_id', $this->expediteur_id);
        })->orderBy('created_at', 'asc')->get();
    }

    public function expediteur()
    {
        return $this->belongsTo(Utilisateur::class, 'expediteur_id');
    }

    public function destinataire()
    {
        return $this->belongsTo(Utilisateur::class, 'destinataire_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }
}
