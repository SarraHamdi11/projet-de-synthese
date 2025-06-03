@extends('layouts.app')

@section('title', 'Logements pour Locataires - FindStay')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="filters">
            <form method="GET" action="{{ route('logementsloca') }}">
                @csrf
                <div class="filter-section">
                    <h3>Prix</h3>
                    <div class="price-range">
                        <input type="number" name="min_price" placeholder="Min" value="{{ request()->input('min_price') }}">
                        <input type="number" name="max_price" placeholder="Max" value="{{ request()->input('max_price') }}">
                    </div>
                </div>
                <div class="filter-section">
                    <h3>Type de recherche</h3>
                    <label><input type="checkbox" name="search_type[]" value="logement" {{ in_array('logement', request()->input('search_type', [])) ? 'checked' : '' }}> Logement</label>
                </div>
                <div class="filter-section">
                    <h3>Type de logement</h3>
                    <label><input type="checkbox" name="logement_type[]" value="Studio" {{ in_array('Studio', request()->input('logement_type', [])) ? 'checked' : '' }}> Studio</label>
                    <label><input type="checkbox" name="logement_type[]" value="Appartement" {{ in_array('Appartement', request()->input('logement_type', [])) ? 'checked' : '' }}> Appartement</label>
                </div>
                <div class="filter-section">
                    <h3>Nombre de colocataires</h3>
                    <label><input type="checkbox" name="colocataires[]" value="1" {{ in_array('1', request()->input('colocataires', [])) ? 'checked' : '' }}> Solo</label>
                    <label><input type="checkbox" name="colocataires[]" value="2" {{ in_array('2', request()->input('colocataires', [])) ? 'checked' : '' }}> 2</label>
                </div>
                <div class="filter-section">
                    <h3>Date d'emménagement</h3>
                    <input type="date" name="move_in_date" value="{{ request()->input('move_in_date') }}">
                </div>
                <div class="filter-section">
                    <h3>Ville</h3>
                    <input type="text" name="city" placeholder="Martil, Casablanca..." value="{{ request()->input('city') }}">
                </div>
                <button type="submit">🔍</button>
            </form>
        </div>

        <div class="listings-grid">
            @forelse($listings as $listing)
                <div class="listing-card">
                    <div class="listing-image">
                        @if($listing->photos)
                            @php $photos = json_decode($listing->photos, true); @endphp
                            @if(is_array($photos) && count($photos) > 0)
                                @php $photoPath = (substr($photos[0], 0, 7) === 'images/') ? $photos[0] : 'images/' . $photos[0]; @endphp
                                <img src="{{ asset($photoPath) }}" alt="Photo du logement">
                            @else
                                <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut">
                            @endif
                        @else
                            <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut">
                        @endif
                        @php
                            $isFavorited = false;
                            if (Auth::check()) {
                                $isFavorited = \App\Models\Favorite::where('user_id', Auth::id())->where('logement_id', $listing->id)->exists();
                            }
                        @endphp
                        <span class="favorite-icon" data-id="{{ $listing->id }}" data-favorited="{{ $isFavorited ? 'true' : 'false' }}">❤</span>
                    </div>
                    <div class="listing-details">
                        <div class="listing-header">
                            <span class="listing-type">{{ $listing->type_log }}</span>
                            <span class="listing-price">{{ number_format($listing->prix_log, 0, ',', '.') }} MAD</span>
                        </div>
                        <p class="listing-city">{{ $listing->ville }}</p>
                        <p class="listing-description">@if($listing->equipements) @foreach(json_decode($listing->equipements, true) as $equipement) <span>{{ $equipement }}</span>@if(!$loop->last), @endif @endforeach @else Aucun @endif</p>
                        <p class="listing-proprietaire"><strong>Propriétaire:</strong> {{ $listing->proprietaire->nom_uti ?? 'Non spécifié' }}</p>
                        <div class="listing-rating">
                            @for ($i = 0; $i < 5; $i++)
                                <span class="star">★</span>
                            @endfor
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('showReservation', $listing->id) }}" class="reserve-btn">RÉSERVER</a>
                            <a href="{{ route('showDetails', $listing->id) }}" class="details-btn">DÉTAILS</a>
                            @if($listing->proprietaire_id)
                                <a href="{{ route('conversations.show', $listing->proprietaire_id) }}" class="contact-btn">CONTACTER</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p>Aucun logement trouvé.</p>
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
                            this.setAttribute('data-favorited', data.is_favorited ? 'true' : 'false');
                            this.style.color = data.is_favorited ? '#e74c3c' : '#ccc';
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
    .container {
        display: flex;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
        gap: 20px;
    }

    .filters {
        width: 250px;
        padding: 15px;
        background: #f5f5f5;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .filter-section {
        margin-bottom: 20px;
    }

    .filter-section h3 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
        text-transform: uppercase;
    }

    .filter-section label {
        display: block;
        margin: 8px 0;
        font-size: 14px;
        color: #666;
    }

    .price-range {
        display: flex;
        gap: 10px;
    }

    .price-range input,
    .filter-section input[type="text"],
    .filter-section input[type="date"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .filters button {
        padding: 8px 15px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
    }

    .listings-grid {
        flex-grow: 1;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .listing-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .listing-image {
        position: relative;
    }

    .listing-image img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .favorite-icon { position: absolute; top: 10px; right: 10px; font-size: 24px; cursor: pointer; color: #fff; transition: color 0.2s; text-shadow: 0 1px 4px rgba(0,0,0,0.2); }
    .favorite-icon[data-favorited="true"] { color: #e74c3c; }

    .listing-details {
        padding: 15px;
    }

    .listing-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .listing-type {
        font-size: 14px;
        font-weight: bold;
        color: #666;
        text-transform: uppercase;
    }

    .listing-price {
        font-size: 16px;
        font-weight: bold;
        color: #e74c3c;
    }

    .listing-city {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }

    .listing-description {
        font-size: 14px;
        color: #666;
        margin: 5px 0 10px;
        line-height: 1.4;
    }

    .listing-rating {
        margin-bottom: 10px;
    }

    .star {
        color: #ddd;
        font-size: 16px;
    }

    .star.filled {
        color: #f1c40f;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 15px;
    }

    .reserve-btn, .details-btn, .contact-btn {
        padding: 8px 15px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .reserve-btn {
        background: #3498db;
        color: white;
    }

    .reserve-btn:hover {
        background: #2980b9;
    }

    .details-btn {
        padding: 12px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: bold;
        text-transform: uppercase;
        background: #24507a;
        color: white;
        transition: all 0.3s ease;
    }

    .details-btn:hover {
        background: #8e44ad;
    }

    .contact-btn {
        background: #2ecc71;
        color: white;
    }

    .contact-btn:hover {
        background: #27ae60;
    }

    .pagination {
        text-align: center;
        margin-top: 30px;
    }

    .pagination a {
        display: inline-block;
        padding: 8px 12px;
        margin: 0 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        color: #007bff;
        font-size: 14px;
        transition: background 0.3s;
    }

    .pagination a:hover {
        background: #f5f5f5;
    }

    .pagination a.active {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .alert-success {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #dbf5e0;
        color: #2d7033;
        padding: 15px 25px;
        border: 1px solid #c3e6cb;
        border-radius: 10px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        min-width: 300px;
        max-width: 90%;
        opacity: 1;
        transition: opacity 0.5s ease-out;
    }

    .alert-success.hide {
        opacity: 0;
        pointer-events: none;
    }

    .listing-proprietaire {
        font-size: 14px;
        color: #666;
        margin: 5px 0;
    }

    /* Chat/conversation modal send button styles */
    #message-form-modal .input-group {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }
    #message-form-modal input[type="text"] {
        flex: 1;
        border-radius: 20px;
        border: 1px solid #ddd;
        padding: 8px 16px;
        font-size: 15px;
    }
    #message-form-modal button[type="submit"] {
        background: #24507a;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 2px 6px rgba(36,80,122,0.12);
        margin-bottom: 0;
        margin-top: 0;
        transition: background 0.2s;
    }
    #message-form-modal button[type="submit"]:hover {
        background: #18375b;
    }
    .chat-footer {
        padding: 10px 0 0 0;
        background: #fff;
        border-top: 1px solid #eee;
        position: static;
    }
</style>