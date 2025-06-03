@extends('layouts.app')

@section('title', 'Conversation')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card chat-card">
                <div class="card-header chat-header d-flex justify-content-between align-items-center" style="background: #24507a; color: #fff;">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $otherUser->prenom }} {{ $otherUser->nom_uti }}</h5>
                            <small class="text-light">{{ $otherUser->role_uti }}</small>
                        </div>
                    </div>
                    <a href="{{ route('conversations.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
                <div class="card-body chat-body">
                    <div class="chat-messages" id="chat-messages">
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
                    <form id="message-form" class="chat-form">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ Auth::id() === $conversation->expediteur_id ? $conversation->destinataire_id : $conversation->expediteur_id }}">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Écrivez votre message..." required>
                            <button type="submit" class="btn send-btn">
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
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(36,80,122,0.08);
}
.chat-header {
    background-color: #24507a !important;
    color: #fff !important;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
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
    border-radius: 8px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}
.message.sent .message-content {
    background-color: #24507a;
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
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
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
.send-btn {
    background: #24507a !important;
    color: #fff !important;
    border: none !important;
    border-radius: 8px !important;
    font-weight: bold;
    font-size: 16px;
    padding: 8px 22px;
    box-shadow: none !important;
    transition: background 0.2s;
}
.send-btn:hover, .send-btn:focus {
    background: #18375b !important;
    color: #fff !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('chat-messages');
    const authUserId = parseInt(messagesContainer.dataset.authId);
    const messageForm = document.getElementById('message-form');
    const fileInput = document.getElementById('fileInput');
    const attachButton = document.getElementById('attachButton');
    const loadingIndicator = document.getElementById('loading');
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

            // Upload file and get URL
            fetch('/upload', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Send message with file
                sendMessage({
                    message: file.name,
                    message_type: file.type.startsWith('image/') ? 'image' : 'file',
                    attachments: [data.url]
                });
            });
        }
    });

    // Scroll to bottom and remove loading indicator
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    loadingIndicator.style.display = 'none';

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
        messageDiv.className = `message-wrapper ${data.sender_id === authUserId ? 'message-sent' : 'message-received'} mb-3`;
        messageDiv.innerHTML = `
            <div class="message-content ${data.sender_id === authUserId ? 'bg-primary text-white' : 'bg-light'} p-3 rounded position-relative">
                ${data.message_type === 'text' ? data.message :
                  data.message_type === 'image' ? `<img src="${data.attachments[0]}" class="img-fluid rounded" alt="Image">` :
                  `<a href="${data.attachments[0]}" class="text-decoration-none" target="_blank">
                      <i class="fas fa-file me-2"></i>Download File
                   </a>`
                }
                <div class="message-time text-end mt-1 ${data.sender_id === authUserId ? 'text-white-50' : 'text-muted'}" style="font-size: 0.8em;">
                    ${new Date(data.created_at).toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}
                    ${data.sender_id === authUserId ? '<i class="fas fa-check-double ms-1"></i>' : ''}
                </div>
                ${data.sender_id === authUserId ? `
                    <button class="btn btn-sm btn-link text-white position-absolute top-0 end-0 delete-message" 
                            data-message-id="${data.id}"
                            style="opacity: 0.5;">
                        <i class="fas fa-times"></i>
                    </button>
                ` : ''}
            </div>
        `;
        messagesContainer.appendChild(messageDiv);
    }

    // Delete message
    messagesContainer.addEventListener('click', function(e) {
        if (e.target.closest('.delete-message')) {
            const messageId = e.target.closest('.delete-message').dataset.messageId;
            if (confirm('Are you sure you want to delete this message?')) {
                fetch(`/messages/${messageId}/delete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        e.target.closest('.message-wrapper').remove();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    });

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
    document.getElementById('message-form').addEventListener('submit', function() {
        typingIndicator.style.display = 'none';
    });
});
</script>
@endpush

@endsection 