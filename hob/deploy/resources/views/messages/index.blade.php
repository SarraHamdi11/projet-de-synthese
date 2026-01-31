@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-lg">
                <div class="card-body p-4">
                    <h2 class="h5 mb-4">{{ __('Conversations') }}</h2>

                    @if($conversations->isEmpty())
                        <p class="text-muted">{{ __('You have no previous conversations.') }}</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($conversations as $message)
                                <li class="list-group-item">
                                    <a href="{{ route('messages.show', ['logement' => $message->logement_id, 'receiver' => $message->sender_id === Auth::id() ? $message->receiver_id : $message->sender_id]) }}" class="text-decoration-none text-dark d-block">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $message->logement->title ?? 'Logement' }}</h6>
                                            <small>{{ $message->created_at->diffForHumans() }}</small>
                                        </div>
                                        @php
                                            $otherUser = ($message->sender_id === Auth::id()) ? $message->receiver : $message->sender;
                                        @endphp
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="{{ $otherUser->photodeprofil_uti ? asset('storage/' . $otherUser->photodeprofil_uti) : asset('images/default-avatar.png') }}" 
                                                 alt="{{ $otherUser->prenom }}" 
                                                 class="rounded-circle me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <p class="mb-0">Conversation with {{ $otherUser->prenom }} {{ $otherUser->nom_uti }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 