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
        text-transform: uppercase;
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
        text-transform: uppercase;
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

    .notif-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--blanc);
        object-fit: cover;
    }

    .notification-item {
        padding: 15px;
        border-bottom: 1px solid var(--creme);
        transition: background 0.3s ease;
    }

    .notification-item:hover {
        background: rgba(124, 159, 192, 0.1);
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
        <h2 class="title-font section-title">Toutes les notifications</h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Consultez vos dernières notifications</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-custom d-flex align-items-center" role="alert">
        <svg class="me-3" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <div>
            <strong>Succès!</strong> {{ session('success') }}
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-custom d-flex align-items-center" role="alert">
        <svg class="me-3" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <strong>Erreur!</strong> {{ session('error') }}
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="professional-card p-4">
        <div class="card-body">
            <ul class="list-unstyled">
                @forelse(auth()->user()->notifications as $notification)
                    <li class="notification-item d-flex align-items-center justify-content-between" data-notification-id="{{ $notification->id }}">
                        <div class="d-flex align-items-center">
                            <img src="{{ $notification->data['avatar'] ?? asset('images/default-avatar.png') }}" class="notif-avatar me-3" alt="avatar">
                            <div>
                                <div class="fw-bold" style="color: var(--bleu-fonce);">{{ $notification->data['name'] ?? 'Utilisateur' }}</div>
                                <div style="color: var(--bleu-moyen);">
                                    @if(isset($notification->data['type']) && $notification->data['type'] === 'reservation')
                                        Demande de réservation
                                    @elseif(isset($notification->data['type']) && $notification->data['type'] === 'comment')
                                        {{ $notification->data['name'] ?? 'Utilisateur' }} a commenté votre poste
                                    @elseif(isset($notification->data['type']) && $notification->data['type'] === 'reservation_status')
                                        {{ $notification->data['message'] ?? '' }}
                                    @else
                                        {{ $notification->data['message'] ?? $notification->data['body'] ?? '' }}
                                    @endif
                                </div>
                                <div class="text-muted small" style="color: var(--bleu-clair);">{{ $notification->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @if(!$notification->read_at)
                            <button class="btn btn-primary-custom btn-sm mark-read-btn" onclick="markAsRead('{{ $notification->id }}')">
                                <i class="fas fa-check"></i>
                            </button>
                        @endif
                    </li>
                @empty
                    <div class="no-content">
                        <i class="fas fa-bell-slash"></i>
                        <p>Aucune notification</p>
                    </div>
                @endforelse
            </ul>
        </div>
    </div>
</div>

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    const markReadBtn = notificationItem.querySelector('.mark-read-btn');
                    if (markReadBtn) {
                        markReadBtn.remove();
                    }
                    
                    const unreadCountElement = document.querySelector('#unread-notifications-count');
                    if (unreadCountElement) {
                        const currentCount = parseInt(unreadCountElement.textContent);
                        if (currentCount > 0) {
                            unreadCountElement.textContent = currentCount - 1;
                            if (currentCount - 1 === 0) {
                                unreadCountElement.style.display = 'none';
                            }
                        }
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
@endpush

@endsection