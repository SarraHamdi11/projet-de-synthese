@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --bleu-fonce: #24507A;
        --bleu-moyen: #447892;
        --bleu-clair: #7C9FC0;
        --creme: #EBDFD5;
        --blanc: #fff;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .title-font {
        font-family: 'Inknut Antiqua', serif;
    }

    .professional-card {
        background: var(--blanc);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(36, 79, 118, 0.08);
        border: 1px solid rgba(36, 79, 118, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .professional-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(36, 79, 118, 0.15);
    }

    .form-label {
        font-weight: 600;
        color: var(--bleu-fonce);
        margin-bottom: 8px;
    }

    .form-control, .form-select, .form-check-input {
        border: 2px solid rgba(36, 79, 118, 0.2);
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--bleu-moyen);
        box-shadow: 0 0 0 0.2rem rgba(68, 120, 146, 0.25);
    }

    .form-control:hover, .form-select:hover, .form-check-input:hover {
        border-color: var(--bleu-clair);
    }

    .form-check-input {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0.25em;
    }

    .form-check-label {
        color: var(--bleu-fonce);
        font-size: 14px;
        margin-left: 8px;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%);
        border: none;
        border-radius: 12px;
        padding: 8px 15px;
        font-weight: 600;
        color: var(--blanc);
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(68, 120, 146, 0.3);
    }

    .btn-secondary-custom {
        background: var(--creme);
        color: var(--bleu-fonce);
        border: 1px solid rgba(36, 79, 118, 0.2);
        border-radius: 12px;
        font-weight: 600;
        padding: 8px 15px;
        transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background: var(--bleu-fonce);
        color: var(--blanc);
        transform: translateY(-1px);
    }

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 40px;
        color: var(--bleu-fonce);
        font-family: 'Inknut Antiqua', serif;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%);
        border-radius: 2px;
    }

    .custom-badge {
        background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%);
        color: var(--blanc);
        border-radius: 12px;
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
    }

    .conversation-item {
        padding: 1rem;
        border-bottom: 1px solid rgba(36, 79, 118, 0.1);
        transition: background-color 0.2s;
    }

    .conversation-item:hover {
        background-color: rgba(124, 159, 192, 0.1);
    }

    .conversation-item.unread {
        background-color: rgba(124, 159, 192, 0.2);
    }

    .conversation-avatar {
        position: relative;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bleu-clair);
        background-color: var(--creme);
        border-radius: 50%;
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
        color: var(--bleu-clair);
        font-weight: 500;
    }

    .conversation-item.unread h6 {
        font-weight: 600;
        color: var(--bleu-fonce);
    }

    .conversation-item.unread .message-prefix {
        color: var(--bleu-moyen);
    }

    .no-content {
        text-align: center;
        padding: 40px 0;
    }

    .no-content i {
        font-size: 3rem;
        color: var(--bleu-clair);
        opacity: 0.5;
    }

    .no-content p {
        color: var(--bleu-fonce);
        font-size: 1.1rem;
        margin-top: 15px;
    }
</style>

<div class="container mx-auto px-4 py-5">
    <div class="text-center mb-5">
        <h2 class="title-font section-title">Mes Conversations</h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Consultez vos conversations en cours</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="professional-card">
                <div class="card-header d-flex justify-content-between align-items-center p-3" style="background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%); color: var(--blanc); border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Mes Conversations
                    </h5>
                    <span class="custom-badge">{{ $conversations->count() }}</span>
                </div>

                <div class="card-body p-0">
                    @if($conversations->isEmpty())
                        <div class="no-content">
                            <i class="fas fa-comments fa-3x"></i>
                            <p>Vous n'avez pas encore de conversations.</p>
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
@endpush

@endsection