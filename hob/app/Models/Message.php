<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;
    
    protected $table = 'messages';  // Fixed table name
    
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'logement_id',
        'message',
        'is_read',
        'read_at',
        'message_type',
        'attachments',
        'is_deleted',
        'deleted_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'attachments' => 'array',
        'is_deleted' => 'boolean',
        'deleted_at' => 'datetime'
    ];

    public function sender()
    {
        return $this->belongsTo(Utilisateur::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Utilisateur::class, 'receiver_id');
    }

    public function logement()
    {
        return $this->belongsTo(Logement::class);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId);
    }
}
