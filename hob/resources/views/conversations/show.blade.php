@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card chat-card">
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
                    <a href="{{ route('conversations.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>

                <div class="card-body chat-body">
                    <div class="chat-messages" id="chat-messages">
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
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.chat-card {
    height: 80vh;
    display: flex;
    flex-direction: column;
}

.chat-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e9ecef;
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
    max-width: 80%;
}

.message.sent {
    margin-left: auto;
    flex-direction: row-reverse;
}

.message-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.message-content {
    background-color: white;
    padding: 0.75rem;
    border-radius: 1rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.message.sent .message-content {
    background-color: #007bff;
    color: white;
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
}

.message-time {
    color: #6c757d;
    font-size: 0.75rem;
}

.message.sent .message-time {
    color: rgba(255,255,255,0.8);
}

.message-text {
    word-wrap: break-word;
}

.chat-form {
    padding: 1rem;
    background-color: white;
    border-top: 1px solid #dee2e6;
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

.chat-form button {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endpush

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
                        <span class="message-time">${new Date().toLocaleTimeString()}</span>
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
                        <span class="message-time">${new Date(message.created_at).toLocaleTimeString()}</span>
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