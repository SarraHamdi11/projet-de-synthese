@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container">
    <h2 class="text-2xl font-bold mb-6">Mes Favoris</h2>
    <div class="row">
        @forelse($favorites as $favorite)
            @if($favorite->logement)
                <div class="col-md-4 mb-4">
                    <div class="card bg-white rounded-xl shadow-lg h-100">
                        <div class="position-relative">
                            @php
                                $photos = json_decode($favorite->logement->photos, true);
                                $firstPhoto = $photos[0] ?? null;
                                $photoPath = $firstPhoto ? (substr($firstPhoto, 0, 7) === 'images/') ? $firstPhoto : 'images/' . $firstPhoto : 'images/default.jpg';
                            @endphp
                            <img src="{{ asset($photoPath) }}" class="card-img-top rounded-t-xl" alt="Photo du logement" style="height: 200px; object-fit: cover;">
                            <span class="favorite-icon position-absolute" 
                                  style="top: 10px; right: 10px; font-size: 24px; cursor: pointer; z-index: 10;"
                                  data-id="{{ $favorite->logement->id }}" 
                                  data-favorited="true">❤</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title font-bold text-lg mb-2">{{ $favorite->logement->type_log }} à {{ $favorite->logement->ville }}</h5>
                            <p class="card-text text-gray-700">
                                <strong>Prix:</strong> {{ number_format($favorite->logement->prix_log, 0, ',', '.') }} MAD<br>
                                <strong>Type:</strong> {{ $favorite->logement->type_log }}<br>
                                <strong>Ville:</strong> {{ $favorite->logement->ville }}
                            </p>
                            <div class="mt-3">
                                <a href="{{ route('showReservation', $favorite->logement->id) }}" class="btn btn-primary btn-sm">RÉSERVER</a>
                                <a href="{{ route('showDetails', $favorite->logement->id) }}" class="btn btn-secondary btn-sm">DÉTAILS</a>
                                @if($favorite->logement->proprietaire_id)
                                    <a href="{{ route('conversations.show', $favorite->logement->proprietaire_id) }}" class="btn btn-info btn-sm">CONTACTER</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Vous n'avez pas encore de favoris.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const favoriteIcons = document.querySelectorAll('.favorite-icon');
            
            if (favoriteIcons.length === 0) { 
                console.log("Aucune icône de favori trouvée."); 
                return; 
            }

            // Set initial color based on data-favorited
            favoriteIcons.forEach(function(icon) {
                icon.style.color = icon.getAttribute('data-favorited') === 'true' ? '#e74c3c' : '#ccc';
            });

            // Add click event listeners
            favoriteIcons.forEach(function(icon) {
                icon.addEventListener('click', function() {
                    const listingId = this.getAttribute('data-id');
                    console.log('Clicked favorite icon for listing', listingId);
                    
                    fetch(`/locataire/favorite/${listingId}`, {
                        method: 'POST',
                        headers: { 
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response from backend:', data);
                        if (data.success) {
                            if (!data.is_favorited) {
                                // Remove the card if unfavorited
                                this.closest('.col-md-4').remove();
                            } else {
                                this.setAttribute('data-favorited', 'true');
                                this.style.color = '#e74c3c';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Une erreur est survenue lors de la mise à jour des favoris.');
                    });
                });
            });
        });
    </script>
@endpush

<style>
    .favorite-icon {
        text-shadow: 0 1px 4px rgba(0,0,0,0.2);
        transition: color 0.2s;
    }
    
    .btn {
        margin-right: 5px;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 20px;
    }
    
    .btn-primary {
        background: #3498db;
        color: white;
    }
    
    .btn-secondary {
        background: #9b59b6;
        color: white;
    }
    
    .btn-info {
        background: #2ecc71;
        color: white;
    }
    
    .btn:hover {
        opacity: 0.9;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }
</style>