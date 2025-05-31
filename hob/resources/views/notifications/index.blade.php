@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Toutes les notifications</h2>
    <div class="card">
        <div class="card-body">
            <ul class="list-unstyled">
                @forelse(auth()->user()->notifications as $notification)
                    <li class="mb-3 d-flex align-items-center">
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
                    </li>
                @empty
                    <li>Aucune notification</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection 