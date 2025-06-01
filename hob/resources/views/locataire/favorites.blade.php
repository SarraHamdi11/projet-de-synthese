@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mes Favoris</h2>
    <div class="row">
        @forelse($favorites as $favorite)
            @if($favorite->logement)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @php
                            $photos = json_decode($favorite->logement->photos, true);
                            $firstPhoto = $photos[0] ?? null;
                        @endphp
                        @if($firstPhoto)
                            <img src="{{ asset($firstPhoto) }}" class="card-img-top" alt="Photo du logement" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Image par défaut" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $favorite->logement->type_log }} à {{ $favorite->logement->ville }}</h5>
                            <p class="card-text">
                                <strong>Prix:</strong> {{ $favorite->logement->prix_log }} MAD<br>
                                <strong>Type:</strong> {{ $favorite->logement->type_log }}<br>
                                <strong>Ville:</strong> {{ $favorite->logement->ville }}
                            </p>
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

@section('scripts')
    <script>
        function toggleFavorite(listingId) {
            const icon = document.querySelector([data-id="${listingId}"]);
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!token) {
                console.error("Jeton CSRF non trouvé.");
                return;
            }

            fetch({{ url('locataire/favorite') }}/${listingId}, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Erreur réseau: ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    icon.setAttribute('data-favorited', data.is_favorited ? 'true' : 'false');
                    icon.style.color = data.is_favorited ? '#e74c3c' : '#ccc';
                    if (!data.is_favorited) {
                        icon.closest('.listing-card').remove();
                    }
                } else {
                    console.error('Échec de la mise à jour des favoris:', data);
                }
            })
            .catch(function(error) {
                console.error('Erreur lors de la requête:', error);
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            const favoriteIcons = document.querySelectorAll('.favorite-icon');
            if (favoriteIcons.length === 0) {
                console.log("Aucune icône de favori trouvée.");
                return;
            }

            favoriteIcons.forEach(function(icon) {
                // Appliquer la couleur initiale
                if (icon.getAttribute('data-favorited') === 'true') {
                    icon.style.color = '#e74c3c';
                } else {
                    icon.style.color = '#ccc';
                }

                icon.addEventListener('click', function () {
                    const listingId = this.getAttribute('data-id');
                    toggleFavorite(listingId);
                });
            });
        });
    </script>
@endsection