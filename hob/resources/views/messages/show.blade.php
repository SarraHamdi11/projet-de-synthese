@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --bleu-fonce: #244F76;
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

    .alert-custom {
        border-radius: 15px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .message-wrapper {
        display: flex;
        margin-bottom: 1rem;
    }

    .message-sent {
        justify-content: flex-end;
    }

    .message-received {
        justify-content: flex-start;
    }

    .message-content {
        max-width: 70%;
        position: relative;
        border-radius: 12px;
    }

    .message-sent .message-content {
        background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%);
        color: var(--blanc);
    }

    .message-received .message-content {
        background: var(--creme);
        color: var(--bleu-fonce);
    }

    .message-content:hover .delete-message {
        opacity: 1 !important;
    }

    .message-time {
        font-size: 0.8em;
        opacity: 0.7;
    }

    .delete-message {
        opacity: 0.5;
        transition: opacity 0.3s ease;
    }

    [data-theme="dark"] {
        background-color: #1a1a1a;
        color: #ffffff;
    }

    [data-theme="dark"] .professional-card {
        background-color: #2d2d2d;
        border-color: #404040;
    }

    [data-theme="dark"] .message-received .message-content {
        background-color: #404040 !important;
        color: #ffffff !important;
    }

    [data-theme="dark"] .message-time {
        color: #a0a0a0 !important;
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
        <h2 class="title-font section-title">Conversation avec {{ $receiver->prenom }} {{ $receiver->nom_uti }}</h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Échangez des messages en toute simplicité</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="professional-card">
                <div class="card-header d-flex justify-content-between align-items-center p-3" style="background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%); color: var(--blanc); border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h3 class="h5 mb-0">
                        <img src="{{ $receiver->photodeprofil_uti ?? asset('images/default-avatar.png') }}" 
                             alt="{{ $receiver->prenom }}" 
                             class="rounded-circle me-2" 
                             style="width: 40px; height: 40px; object-fit: cover;">
                        {{ $receiver->prenom }} {{ $receiver->nom_uti }}
                    </h3>
                    <div>
                        <button class="btn btn-secondary-custom btn-sm" id="toggleTheme">
                            <i class="fas fa-moon"></i>
                        </button>
                        <a href="{{ route('messages.index') }}" class="btn btn-secondary-custom btn-sm ms-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div id="messages" class="mb-4" data-auth-id="{{ Auth::id() }}" style="height: 400px; overflow-y: auto; padding-right: 10px;">
                        <div class="text-center py-3" id="loading">
                            <div class="spinner-border" style="color: var(--bleu-moyen);" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        @foreach($messages as $message)
                            <div class="message-wrapper {{ $message->sender_id === Auth::id() ? 'message-sent' : 'message-received' }} mb-3">
                                <div class="message-content p-3 position-relative">
                                    @if($message->message_type === 'text')
                                        {{ $message->message }}
                                    @elseif($message->message_type === 'image')
                                        <img src="{{ $message->attachments[0] }}" class="img-fluid rounded" alt="Image">
                                    @elseif($message->message_type === 'file')
                                        <a href="{{ $message->attachments[0] }}" class="text-decoration-none" target="_blank">
                                            <i class="fas fa-file me-2"></i>Download File
                                        </a>
                                    @endif
                                    <div class="message-time text-end mt-1" style="font-size: 0.8em;">
                                        {{ $message->created_at->format('H:i') }}
                                        @if($message->sender_id === Auth::id())
                                            <i class="fas fa-check-double {{ $message->is_read ? 'text-info' : '' }} ms-1"></i>
                                        @endif
                                    </div>
                                    @if($message->sender_id === Auth::id())
                                        <button class="btn btn-sm btn-link position-absolute top-0 end-0 delete-message" 
                                                data-message-id="{{ $message->id }}"
                                                style="color: var(--blanc); opacity: 0.5;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form id="message-form" class="mt-4">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                        <div class="input-group">
                            <button type="button" class="btn btn-secondary-custom" id="attachButton">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <input type="file" id="fileInput" class="d-none" accept="image/*,.pdf,.doc,.docx">
                            <input type="text" name="message" class="form-control" placeholder="{{ __('Écrivez votre message...') }}" required>
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
    const messagesContainer = document.getElementById('messages');
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
            <div class="message-content p-3 rounded position-relative">
                ${data.message_type === 'text' ? data.message :
                  data.message_type === 'image' ? `<img src="${data.attachments[0]}" class="img-fluid rounded" alt="Image">` :
                  `<a href="${data.attachments[0]}" class="text-decoration-none" target="_blank">
                      <i class="fas fa-file me-2"></i>Download File
                   </a>`
                }
                <div class="message-time text-end mt-1" style="font-size: 0.8em;">
                    ${new Date(data.created_at).toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}
                    ${data.sender_id === authUserId ? `<i class="fas fa-check-double ${data.is_read ? 'text-info' : ''} ms-1"></i>` : ''}
                </div>
                ${data.sender_id === authUserId ? `
                    <button class="btn btn-sm btn-link position-absolute top-0 end-0 delete-message" 
                            data-message-id="${data.id}"
                            style="color: var(--blanc); opacity: 0.5;">
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
});
</script>
@endpush

@endsection