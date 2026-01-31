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
        padding: 10px 20px;
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
        padding: 10px 20px;
        transition: all 0.3s ease;
        text-transform: uppercase;
    }

    .btn-secondary-custom:hover {
        background: var(--bleu-fonce);
        color: var(--blanc);
        transform: translateY(-1px);
    }

    .btn-contact-custom {
        background: #2ecc71; /* Vert similaire à btn-info */
        color: var(--blanc);
        border: none;
        border-radius: 12px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
        text-transform: uppercase;
    }

    .btn-contact-custom:hover {
        background: #27ae60;
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

    .favorite-icon {
        text-shadow: 0 1px 4px rgba(0,0,0,0.2);
        transition: color 0.2s;
        font-size: 24px;
        cursor: pointer;
        z-index: 10;
    }

    .alert-custom {
        border-radius: 15px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
        <h2 class="title-font section-title">Mes Favoris</h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Découvrez et gérez vos logements favoris</p>
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

    <div class="row g-4">
        @forelse($favorites as $favorite)
            @if($favorite->logement)
                <div class="col-md-4">
                    <div class="professional-card h-100">
                        <div class="position-relative">
                            @php
                                $photos = json_decode($favorite->logement->photos, true);
                                $firstPhoto = $photos[0] ?? null;
                                $photoPath = $firstPhoto ? (substr($firstPhoto, 0, 7) === 'images/') ? $firstPhoto : 'images/' . $firstPhoto : 'images/default.jpg';
                            @endphp
                            <img src="{{ asset($photoPath) }}" class="rounded-t-xl w-100" alt="Photo du logement" style="height: 200px; object-fit: cover;">
                            <span class="favorite-icon position-absolute" 
                                  style="top: 10px; right: 10px;"
                                  data-id="{{ $favorite->logement->id }}" 
                                  data-favorited="true">❤</span>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title title-font font-semibold text-lg mb-2" style="color: var(--bleu-fonce);">
                                {{ $favorite->logement->type_log }} à {{ $favorite->logement->ville }}
                            </h5>
                            <p class="card-text text-gray-700" style="color: var(--bleu-moyen);">
                                <strong>Prix:</strong> {{ number_format($favorite->logement->prix_log, 0, ',', '.') }} MAD<br>
                                <strong>Type:</strong> {{ $favorite->logement->type_log }}<br>
                                <strong>Ville:</strong> {{ $favorite->logement->ville }}
                            </p>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('showReservation', $favorite->logement->id) }}" class="btn btn-primary btn-sm">Réserver</a>
                                <a href="{{ route('showDetails', $favorite->logement->id) }}" class="btn btn-outline-primary btn-sm">Détails</a>
                                @if($favorite->logement->proprietaire_id)
                                    <a href="{{ route('conversations.show', $favorite->logement->proprietaire_id) }}" class="btn btn-primary btn-sm">Contacter</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col-12">
                <div class="professional-card no-content">
                    <i class="fas fa-heart-broken"></i>
                    <p>Vous n'avez pas encore de favoris.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

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

@endsection