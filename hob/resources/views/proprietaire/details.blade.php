@extends('layouts.app')

@section('title', 'Détails du Logement - FindStay')

@section('content')
    <div class="details-container">
        @if ($listing)
            <div class="details-header">
                <h2>{{ $listing->type_log ?? 'Logement' }} à {{ $listing->ville ?? 'Inconnu' }}</h2>
                <a href="{{ route('proprietaire.logements') }}" class="back-btn">← Retour</a>
            </div>
            <div class="details-content">
                <div class="details-image">
                    @if($listing->photos)
                        @php $photos = json_decode($listing->photos, true); @endphp
                        @if(is_array($photos) && count($photos) > 0)
                            @foreach($photos as $photo)
                                @php $photoPath = (substr($photo, 0, 7) === 'images/') ? $photo : 'images/' . $photo; @endphp
                                @if(file_exists(public_path($photoPath)))
                                    <img src="{{ asset($photoPath) }}" alt="Photo du logement" style="max-width:300px; margin:5px;">
                                @else
                                    <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut" style="max-width:300px; margin:5px;">
                                @endif
                            @endforeach
                        @else
                            <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut" style="max-width:300px; margin:5px;">
                        @endif
                    @else
                        <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut" style="max-width:300px; margin:5px;">
                    @endif
                </div>
                <div class="details-info">
                    <p class="details-price">{{ number_format($listing->prix_log ?? 0, 0, ',', '.') }} MAD</p>
                    <p><strong>Ville :</strong> {{ $listing->ville ?? 'N/A' }}</p>
                    <p><strong>Nombre de colocataires autorisés :</strong> {{ $listing->nombre_colocataire_log ?? 'N/A' }}</p>
                    <p><strong>Étage :</strong> {{ $listing->etage ?? 'N/A' }}</p>
                    <p><strong>Équipements :</strong> 
                        @if($listing->equipements)
                            @foreach(json_decode($listing->equipements, true) as $equipement)
                                <span>{{ $equipement }}</span>@if(!$loop->last), @endif
                            @endforeach
                        @else
                            Aucun
                        @endif
                    </p>
                </div>
            </div>
        @else
            <p>Aucun logement trouvé. <a href="{{ route('proprietaire.logements') }}">Retour à la liste</a></p>
        @endif
    </div>

    <!-- Avis Section -->
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h3 class="card-title mb-4">Avis</h3>
            <div class="avis-list">
                @forelse($listing->annonce->avis as $avis)
                    <div class="avis mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ $avis->locataire->photodeprofil_uti ? asset($avis->locataire->photodeprofil_uti) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $avis->locataire->prenom }}" 
                                 class="rounded-circle me-2" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">{{ $avis->locataire->prenom }} {{ $avis->locataire->nom_uti }}</h6>
                                <small class="text-muted">{{ $avis->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        <p class="mb-0">{{ $avis->contenu }}</p>
                    </div>
                @empty
                    <p class="text-muted">Aucun avis pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

<style>
    .details-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .details-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .details-header h2 {
        font-size: 24px;
        color: #333;
    }

    .back-btn {
        display: inline-block;
        padding: 8px 15px;
        background: #6c757d;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        transition: background 0.3s;
    }

    .back-btn:hover {
        background: #5a6268;
    }

    .details-content {
        display: flex;
        gap: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .details-image {
        flex: 1;
    }

    .details-image img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
    }

    .details-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .details-price {
        font-size: 20px;
        font-weight: bold;
        color: #e74c3c;
        margin-bottom: 15px;
    }

    .details-description {
        font-size: 16px;
        color: #666;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .details-rating {
        margin-bottom: 20px;
    }

    .star {
        color: #ddd;
        font-size: 18px;
    }

    .star.filled {
        color: #f1c40f;
    }

    .details-actions {
        display: flex;
        gap: 10px;
    }

   

  
    .contact-btn {
        display: inline-block;
        padding: 10px 20px;
        background: #666;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        text-transform: uppercase;
        transition: background 0.3s;
    }

    .contact-btn:hover {
        background: #555;
    }
</style>