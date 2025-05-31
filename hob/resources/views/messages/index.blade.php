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
                                        <p class="mb-1">Conversation with {{ $message->sender_id === Auth::id() ? $message->receiver->prenom : $message->sender->prenom }} {{ $message->sender_id === Auth::id() ? $message->receiver->nom_uti : $message->sender->nom_uti }}</p>
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