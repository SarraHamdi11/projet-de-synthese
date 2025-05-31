@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Mes Conversations
                    </h5>
                    <span class="badge bg-primary">{{ $conversations->count() }}</span>
                </div>

                <div class="card-body p-0">
                    @if($conversations->isEmpty())
                        <div class="text-center p-4">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Vous n'avez pas encore de conversations.</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($conversations as $conversation)
                                @php
                                    $otherUser = $conversation->expediteur_id === auth()->id() 
                                        ? $conversation->destinataire 
                                        : $conversation->expediteur;
                                    $lastMessage = $conversation->allMessages()->first();
                                    $unreadCount = $conversation->allMessages()
                                        ->where('receiver_id', auth()->id())
                                        ->where('is_read', false)
                                        ->count();
                                @endphp
                                <a href="{{ route('conversations.show', $otherUser->id) }}" 
                                   class="list-group-item list-group-item-action conversation-item {{ $unreadCount > 0 ? 'unread' : '' }}">
                                    <div class="d-flex align-items-center">
                                        <div class="conversation-avatar me-3">
                                            <i class="fas fa-user-circle fa-2x"></i>
                                            @if($unreadCount > 0)
                                                <span class="unread-badge">{{ $unreadCount }}</span>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-1">
                                                    {{ $otherUser->nom }} {{ $otherUser->prenom }}
                                                    <small class="text-muted">
                                                        ({{ $otherUser->id === $conversation->expediteur_id ? 'Propriétaire' : 'Locataire' }})
                                                    </small>
                                                </h6>
                                                @if($lastMessage)
                                                    <small class="text-muted">
                                                        {{ $lastMessage->created_at->diffForHumans() }}
                                                    </small>
                                                @endif
                                            </div>
                                            @if($lastMessage)
                                                <p class="mb-1 text-truncate">
                                                    <span class="message-prefix">
                                                        {{ $lastMessage->sender_id === auth()->id() ? 'Vous: ' : '' }}
                                                    </span>
                                                    {{ $lastMessage->message }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.conversation-item {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
    transition: background-color 0.2s;
}

.conversation-item:hover {
    background-color: #f8f9fa;
}

.conversation-item.unread {
    background-color: #e8f4ff;
}

.conversation-avatar {
    position: relative;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

.unread-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.message-prefix {
    color: #6c757d;
    font-weight: 500;
}

.conversation-item.unread h6 {
    font-weight: 600;
}

.conversation-item.unread .message-prefix {
    color: #007bff;
}
</style>
@endpush
@endsection 