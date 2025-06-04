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
        height: 80vh;
        display: flex;
        flex-direction: column;
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

    .chat-header {
        background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%);
        color: var(--blanc);
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        border-bottom: 1px solid rgba(36, 79, 118, 0.2);
        padding: 1rem;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--creme);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 0;
        background-color: #f8f9fa;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .message {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        max-width: 70%;
    }

    .message.sent {
        margin-left: auto;
        flex-direction: row-reverse;
    }

    .message-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: var(--creme);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .message-content {
        background-color: var(--blanc);
        padding: 0.75rem;
        border-radius: 12px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .message.sent .message-content {
        background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%);
        color: var(--blanc);
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    .message-sender {
        font-weight: 600;
        color: var(--bleu-fonce);
    }

    .message.sent .message-sender {
        color: var(--blanc);
    }

    .message-time {
        color: var(--bleu-clair);
        font-size: 0.75rem;
    }

    .message.sent .message-time {
        color: rgba(255,255,255,0.8);
    }

    .message-text {
        word-wrap: break-word;
        color: var(--bleu-moyen);
    }

    .message.sent .message-text {
        color: var(--blanc);
    }

    .chat-form {
        padding: 1rem;
        background-color: var(--blanc);
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top: 1px solid rgba(36, 79, 118, 0.2);
    }

    .chat-form .input-group {
        background-color: #f8f9fa;
        border-radius: 2rem;
        padding: 0.5rem;
    }

    .chat-form input {
        border: none;
        background: transparent;
        padding: 0.5rem 1rem;
    }

    .chat-form input:focus {
        box-shadow: none;
    }
</style>

<div class="container mx-auto px-4 py-5">
    <div class="text-center mb-5">
        <h2 class="title-font section-title">Conversation avec {{ $proprietaire->nom }} {{ $proprietaire->prenom }}</h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Échangez des messages avec le propriétaire</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="professional-card">
                <div class="card-header chat-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $proprietaire->nom }} {{ $proprietaire->prenom }}</h5>
                            <small class="text-muted">Propriétaire</small>
                        </div>
                    </div>
                    <a href="{{ route('conversations.index') }}" class="btn btn-secondary-custom">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>

                <div class="card-body chat-body">
                    <div class="chat-messages" id="chat-messages">
                        @php
                            $lastSentMessage = $messages->where('sender_id', auth()->id())->last();
                        @endphp
                        @foreach($messages as $message)
                            <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                                @if($message->sender_id !== auth()->id())
                                    <div class="message-avatar">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                @endif
                                <div class="message-content">
                                    <div class="message-header">
                                        <span class="message-sender">
                                            {{ $message->sender_id === auth()->id() ? 'Vous' : $proprietaire->nom }}
                                        </span>
                                        <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                                    </div>
                                    <div class="message-text">{{ $message->message }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form id="message-form" class="chat-form">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $proprietaire->id }}">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Écrivez votre message..." required>
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('message-form');
    const chatMessages = document.getElementById('chat-messages');
    const messageInput = messageForm.querySelector('input[name="message"]');

    // Scroll to bottom of chat
    chatMessages.scrollTop = chatMessages.scrollHeight;

    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(messageForm);
        formData.append('message_type', 'text');

        fetch('{{ route("messages.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Add new message to chat
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message sent';
            messageDiv.innerHTML = `
                <div class="message-content">
                    <div class="message-header">
                        <span class="message-sender">Vous</span>
                        <span class="message-time">${new Date().toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}</span>
                    </div>
                    <div class="message-text">${data.message}</div>
                </div>
            `;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            messageInput.value = '';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue lors de l\'envoi du message.');
        });
    });

    // Listen for new messages
    Echo.private('messages.{{ auth()->id() }}')
        .listen('NewMessage', (e) => {
            const message = e.message;
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message received';
            messageDiv.innerHTML = `
                <div class="message-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="message-content">
                    <div class="message-header">
                        <span class="message-sender">{{ $proprietaire->nom }}</span>
                        <span class="message-time">${new Date(message.created_at).toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}</span>
                    </div>
                    <div class="message-text">${message.message}</div>
                </div>
            `;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            // Show notification
            if (Notification.permission === "granted") {
                new Notification("Nouveau message", {
                    body: `Message de ${message.sender.nom}: ${message.message}`,
                    icon: "/path/to/icon.png"
                });
            }
        });
});
</script>
@endpush

@endsection