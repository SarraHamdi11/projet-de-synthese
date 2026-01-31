@extends('layouts.app')

@section('title', 'Conversation')

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
        padding-bottom: 30px;
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

    #typing-indicator {
        display: none;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: var(--bleu-clair);
    }

    [data-theme="dark"] {
        background-color: #1a1a1a;
        color: #ffffff;
    }

    [data-theme="dark"] .professional-card {
        background-color: #2d2d2d;
        border-color: #404040;
    }

    [data-theme="dark"] .chat-body {
        background-color: #1a1a1a;
    }

    [data-theme="dark"] .chat-form {
        background-color: #2d2d2d;
    }

    [data-theme="dark"] .chat-form .input-group {
        background-color: #404040;
    }

    [data-theme="dark"] .message.received .message-content {
        background-color: #404040;
        color: #ffffff;
    }

    [data-theme="dark"] .message-time {
        color: #a0a0a0;
    }

    [data-theme="dark"] .message-sender {
        color: #ffffff;
    }

    [data-theme="dark"] .message-text {
        color: #ffffff;
    }

    [data-theme="dark"] .form-control {
        background-color: #2d2d2d;
        color: #ffffff;
        border-color: #404040;
    }

    [data-theme="dark"] .btn-secondary-custom {
        background: #404040;
        color: #ffffff;
        border-color: #555;
    }

    [data-theme="dark"] .btn-secondary-custom:hover {
        background: var(--bleu-fonce);
        color: var(--blanc);
    }
</style>

<div class="container mx-auto px-4 py-5">
    <div class="text-center mb-5">
        <h2 class="title-font section-title">Conversation avec {{ $otherUser->prenom }} {{ $otherUser->nom_uti }}</h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Échangez des messages avec {{ $otherUser->role_uti }}</p>
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
                            <h5 class="mb-0">{{ $otherUser->prenom }} {{ $otherUser->nom_uti }}</h5>
                            <small class="text-light">{{ $otherUser->role_uti }}</small>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-secondary-custom btn-sm" id="toggleTheme">
                            <i class="fas fa-moon"></i>
                        </button>
                        <a href="{{ route('conversations.index') }}" class="btn btn-secondary-custom btn-sm ms-2">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body chat-body">
                    <div class="chat-messages" id="chat-messages" data-auth-id="{{ Auth::id() }}">
                        @php
                            $lastSentMessage = $conversation->allMessages()->where('sender_id', Auth::id())->last();
                        @endphp
                        @foreach($conversation->allMessages() as $message)
                            <div class="message {{ $message->sender_id === Auth::id() ? 'sent' : 'received' }}">
                                @if($message->sender_id !== Auth::id())
                                    <div class="message-avatar">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                @endif
                                <div class="message-content">
                                    <div class="message-header">
                                        <span class="message-sender">
                                            {{ $message->sender_id === Auth::id() ? 'Vous' : $otherUser->prenom }}
                                        </span>
                                        <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                                    </div>
                                    <div class="message-text">
                                        @if($message->message_type === 'text')
                                            {{ $message->message }}
                                        @elseif($message->message_type === 'image')
                                            <img src="{{ $message->attachments[0] }}" class="img-fluid rounded" alt="Image">
                                        @elseif($message->message_type === 'file')
                                            <a href="{{ $message->attachments[0] }}" class="text-decoration-none" target="_blank">
                                                <i class="fas fa-file me-2"></i>Download File
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="typing-indicator">
                        <i class="fas fa-ellipsis-h"></i> {{ $otherUser->prenom }} est en train d'écrire...
                    </div>
                    <form id="message-form" class="chat-form">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ Auth::id() === $conversation->expediteur_id ? $conversation->destinataire_id : $conversation->expediteur_id }}">
                        <div class="input-group">
                            <button type="button" class="btn btn-secondary-custom" id="attachButton">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <input type="file" id="fileInput" class="d-none" accept="image/*,.pdf,.doc,.docx">
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
    const messagesContainer = document.getElementById('chat-messages');
    const authUserId = parseInt(messagesContainer.dataset.authId);
    const messageForm = document.getElementById('message-form');
    const fileInput = document.getElementById('fileInput');
    const attachButton = document.getElementById('attachButton');
    const themeToggle = document.getElementById('toggleTheme');

    // Theme toggle
    themeToggle.addEventListener('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        themeToggle.innerHTML = newTheme === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
    });

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    themeToggle.innerHTML = savedTheme === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';

    // File attachment handling
    attachButton.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('receiver_id', messageForm.querySelector('[name="receiver_id"]').value);

            fetch('/upload', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                sendMessage({
                    message: file.name,
                    message_type: file.type.startsWith('image/') ? 'image' : 'file',
                    attachments: [data.url]
                });
            });
        }
    });

    // Scroll to bottom
    messagesContainer.scrollTop = messagesContainer.scrollHeight;

    // Handle form submission
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const messageInput = this.querySelector('[name="message"]');
        if (messageInput.value.trim()) {
            sendMessage({
                message: messageInput.value,
                message_type: 'text'
            });
            messageInput.value = '';
        }
    });

    function sendMessage(data) {
        const formData = new FormData();
        Object.keys(data).forEach(key => formData.append(key, data[key]));
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('receiver_id', messageForm.querySelector('[name="receiver_id"]').value);

        fetch('{{ route("messages.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            appendMessage(data);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        })
        .catch(error => console.error('Error:', error));
    }

    function appendMessage(data) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${data.sender_id === authUserId ? 'sent' : 'received'}`;
        messageDiv.innerHTML = `
            ${data.sender_id !== authUserId ? `
                <div class="message-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
            ` : ''}
            <div class="message-content">
                <div class="message-header">
                    <span class="message-sender">
                        ${data.sender_id === authUserId ? 'Vous' : '{{ $otherUser->prenom }}'}
                    </span>
                    <span class="message-time">${new Date(data.created_at).toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}</span>
                </div>
                <div class="message-text">
                    ${data.message_type === 'text' ? data.message :
                      data.message_type === 'image' ? `<img src="${data.attachments[0]}" class="img-fluid rounded" alt="Image">` :
                      `<a href="${data.attachments[0]}" class="text-decoration-none" target="_blank">
                          <i class="fas fa-file me-2"></i>Download File
                       </a>`
                    }
                </div>
            </div>
        `;
        messagesContainer.appendChild(messageDiv);
    }

    // Real-time updates using Laravel Echo
    window.Echo.private(`chat.${authUserId}`)
        .listen('NewMessage', (e) => {
            appendMessage(e.message);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        })
        .listen('MessageRead', (e) => {
            const messageElement = document.querySelector(`[data-message-id="${e.id}"]`);
            if (messageElement) {
                messageElement.querySelector('.fa-check-double').classList.add('text-info');
            }
        });

    const messageInput = document.querySelector('#message-form [name="message"]');
    const typingIndicator = document.getElementById('typing-indicator');
    let typingTimeout;
    messageInput.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            typingIndicator.style.display = 'block';
            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                typingIndicator.style.display = 'none';
            }, 1500);
        } else {
            typingIndicator.style.display = 'none';
        }
    });

    messageForm.addEventListener('submit', function() {
        typingIndicator.style.display = 'none';
    });
});
</script>
@endpush

@endsection