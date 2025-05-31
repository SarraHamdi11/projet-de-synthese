@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $logement->titre_anno }}</h2>
                </div>
                <div class="card-body">
                    @if($logement->photos)
                        <div class="mb-4">
                            @php
                                $photos = json_decode($logement->photos, true);
                                $firstPhoto = $photos[0] ?? null;
                            @endphp
                            @if($firstPhoto)
                                <img src="{{ asset($firstPhoto) }}" alt="Photo du logement" class="img-fluid rounded">
                            @endif
                        </div>
                    @endif

                    <div class="mb-4">
                        <h3>Détails</h3>
                        <p><strong>Prix:</strong> {{ $logement->prix_log }} DH/mois</p>
                        <p><strong>Localisation:</strong> {{ $logement->localisation_log }}</p>
                        <p><strong>Type:</strong> {{ $logement->type_log }}</p>
                        @if($logement->equipements)
                            <p><strong>Équipements:</strong> {{ implode(', ', json_decode($logement->equipements, true)) }}</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h3>Description</h3>
                        <p>{{ $logement->description_anno }}</p>
                    </div>

                    @auth
                        @if(Auth::id() !== $logement->user_id)
                            <div class="text-center">
                                <a href="{{ route('messages.show', ['logement' => $logement->id, 'receiver' => $logement->user_id]) }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-envelope"></i> Contacter le propriétaire
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center">
                            <p>Veuillez vous connecter pour contacter le propriétaire</p>
                            <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 