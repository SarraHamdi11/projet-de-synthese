@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Toutes les notifications</h2>
    <div class="card">
        <div class="card-body">
            <ul class="list-unstyled">
                @forelse(auth()->user()->notifications as $notification)
                    <li class="mb-3 d-flex align-items-center justify-content-between notification-item" data-notification-id="{{ $notification->id }}">
                        <div class="d-flex align-items-center">
                            <img src="{{ $notification->data['avatar'] ?? asset('images/default-avatar.png') }}" class="notif-avatar me-3" alt="avatar" style="width:44px;height:44px;border-radius:50%;background:#fff;object-fit:cover;">
                            <div>
                                <div class="fw-bold">{{ $notification->data['name'] ?? 'Utilisateur' }}</div>
                                <div>
                                    @if(isset($notification->data['type']) && $notification->data['type'] === 'reservation')
                                        demande de reservation
                                    @elseif(isset($notification->data['type']) && $notification->data['type'] === 'comment')
                                        {{ $notification->data['name'] ?? 'Utilisateur' }} a commenté votre poste
                                    @elseif(isset($notification->data['type']) && $notification->data['type'] === 'reservation_status')
                                        {{ $notification->data['message'] ?? '' }}
                                    @else
                                        {{ $notification->data['message'] ?? $notification->data['body'] ?? '' }}
                                    @endif
                                </div>
                                <div class="text-muted small">{{ $notification->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @if(!$notification->read_at)
                            <button class="btn btn-sm btn-outline-primary mark-read-btn" onclick="markAsRead('{{ $notification->id }}')">
                                <i class="fas fa-check"></i>
                            </button>
                        @endif
                    </li>
                @empty
                    <li>Aucune notification</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

@push('scripts')
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
            // Remove the mark as read button
            const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
            const markReadBtn = notificationItem.querySelector('.mark-read-btn');
            if (markReadBtn) {
                markReadBtn.remove();
            }
            
            // Update the unread count in the navbar
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