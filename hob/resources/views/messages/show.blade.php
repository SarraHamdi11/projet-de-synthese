{{-- resources/views/messages/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="h5 mb-0">
                        <img src="{{ $receiver->photodeprofil_uti ?? asset('images/default-avatar.png') }}" 
                             alt="{{ $receiver->prenom }}" 
                             class="rounded-circle me-2" 
                             style="width: 40px; height: 40px; object-fit: cover;">
                        {{ $receiver->prenom }} {{ $receiver->nom_uti }}
                    </h3>
                    <div>
                        <button class="btn btn-light btn-sm" id="toggleTheme">
                            <i class="fas fa-moon"></i>
                        </button>
                        <a href="{{ route('messages.index') }}" class="btn btn-light btn-sm ms-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- Messages container with loading animation --}}
                    <div id="messages" class="mb-4" data-auth-id="{{ Auth::id() }}" style="height: 400px; overflow-y: auto;">
                        <div class="text-center py-3" id="loading">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        @foreach($messages as $message)
                            <div class="message-wrapper {{ $message->sender_id === Auth::id() ? 'message-sent' : 'message-received' }} mb-3">
                                <div class="message-content {{ $message->sender_id === Auth::id() ? 'bg-primary text-white' : 'bg-light' }} p-3 rounded position-relative">
                                    @if($message->message_type === 'text')
                                        {{ $message->message }}
                                    @elseif($message->message_type === 'image')
                                        <img src="{{ $message->attachments[0] }}" class="img-fluid rounded" alt="Image">
                                    @elseif($message->message_type === 'file')
                                        <a href="{{ $message->attachments[0] }}" class="text-decoration-none" target="_blank">
                                            <i class="fas fa-file me-2"></i>Download File
                                        </a>
                                    @endif
                                    <div class="message-time text-end mt-1 {{ $message->sender_id === Auth::id() ? 'text-white-50' : 'text-muted' }}" style="font-size: 0.8em;">
                                        {{ $message->created_at->format('H:i') }}
                                        @if($message->sender_id === Auth::id())
                                            <i class="fas fa-check-double {{ $message->is_read ? 'text-info' : '' }} ms-1"></i>
                                        @endif
                                    </div>
                                    @if($message->sender_id === Auth::id())
                                        <button class="btn btn-sm btn-link text-white position-absolute top-0 end-0 delete-message" 
                                                data-message-id="{{ $message->id }}"
                                                style="opacity: 0.5;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Message input form with file upload --}}
                    <form id="message-form" class="mt-4">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary" id="attachButton">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <input type="file" id="fileInput" class="d-none" accept="image/*,.pdf,.doc,.docx">
                            <input type="text" name="message" class="form-control" placeholder="{{ __('Écrivez votre message...') }}" required>
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
<style>
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
    }
    .message-content:hover .delete-message {
        opacity: 1 !important;
    }
    [data-theme="dark"] {
        background-color: #1a1a1a;
        color: #ffffff;
    }
    [data-theme="dark"] .card {
        background-color: #2d2d2d;
        border-color: #404040;
    }
    [data-theme="dark"] .bg-light {
        background-color: #404040 !important;
        color: #ffffff !important;
    }
    [data-theme="dark"] .text-muted {
        color: #a0a0a0 !important;
    }
</style>
@endpush

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
});
</script>
@endpush

@endsection
