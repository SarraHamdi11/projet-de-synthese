@extends('layouts.app')

@section('title', 'Détails du Logement - FindStay')

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

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 20px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%);
        border-radius: 2px;
    }

    .details-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .back-btn {
        display: inline-block;
        padding: 8px 15px;
        background: var(--bleu-moyen);
        color: var(--blanc);
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        transition: background 0.3s;
    }

    .back-btn:hover {
        background: var(--bleu-fonce);
    }

    .details-content {
        display: flex;
        gap: 20px;
    }

    .details-image-grid {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
    }

    .details-image-grid img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        background: var(--creme);
        transition: transform 0.3s ease;
    }

    .details-image-grid img:hover {
        transform: scale(1.05);
    }

    .details-info-card {
        flex: 1;
        padding: 20px;
        background: var(--blanc);
        border-radius: 16px;
        border: 1.5px solid var(--creme);
        transition: all 0.3s ease;
    }

    .details-info-card:hover {
        border-color: var(--bleu-clair);
        box-shadow: 0 10px 30px rgba(36, 79, 118, 0.1);
        transform: translateY(-3px);
    }

    .details-info-card .details-price {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--bleu-fonce);
        margin-bottom: 15px;
    }

    .details-info-card p {
        margin: 0 0 10px;
        color: var(--bleu-moyen);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }

    .details-info-card p i {
        color: var(--bleu-fonce);
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .details-info-card p strong {
        color: var(--bleu-fonce);
        margin-right: 5px;
    }

    .avis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .avis-card {
        display: flex;
        align-items: center;
        background: var(--blanc);
        border-radius: 16px;
        border: 1.5px solid var(--creme);
        padding: 16px;
        transition: all 0.3s ease;
    }

    .avis-card:hover {
        border-color: var(--bleu-clair);
        box-shadow: 0 10px 30px rgba(36, 79, 118, 0.1);
        transform: translateY(-3px);
    }

    .avis-card img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--bleu-clair);
    }

    .avis-card-content {
        margin-left: 15px;
        flex-grow: 1;
    }

    .avis-card-content h6 {
        margin: 0;
        color: var(--bleu-fonce);
        font-size: 1rem;
    }

    .avis-card-content small {
        color: var(--bleu-clair);
        font-size: 0.9rem;
    }

    .avis-card-content p {
        margin: 5px 0 0;
        color: var(--bleu-moyen);
        font-size: 0.95rem;
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

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }
</style>

<div class="container">
    @if ($listing)
        <!-- Header -->
        <div class="details-header">
            <h2 class="title-font section-title" style="color: var(--bleu-fonce); font-size: 2rem; font-weight: 700;">
                {{ $listing->type_log ?? 'Logement' }} à {{ $listing->ville ?? 'Inconnu' }}
            </h2>
            <a href="{{ route('proprietaire.logements') }}" class="back-btn">← Retour</a>
        </div>

        <!-- Main Content -->
        <div class="details-content mb-5">
            <!-- Images -->
            <div class="details-image-grid">
                @if($listing->photos)
                    @php $photos = json_decode($listing->photos, true); @endphp
                    @if(is_array($photos) && count($photos) > 0)
                        @foreach($photos as $photo)
                            @php $photoPath = (substr($photo, 0, 7) === 'images/') ? $photo : 'images/' . $photo; @endphp
                            @if(file_exists(public_path($photoPath)))
                                <img src="{{ asset($photoPath) }}" alt="Photo du logement">
                            @else
                                <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut">
                            @endif
                        @endforeach
                    @else
                        <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut">
                    @endif
                @else
                    <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut">
                @endif
            </div>

            <!-- Info -->
            <div class="details-info-card">
                <p class="details-price">{{ number_format($listing->prix_log ?? 0, 0, ',', '.') }} MAD</p>
                <p><i class="fas fa-map-marker-alt"></i><strong>Ville :</strong> {{ $listing->ville ?? 'N/A' }}</p>
                <p><i class="fas fa-users"></i><strong>Nombre de colocataires autorisés :</strong> {{ $listing->nombre_colocataire_log ?? 'N/A' }}</p>
                <p><i class="fas fa-building"></i><strong>Étage :</strong> {{ $listing->etage ?? 'N/A' }}</p>
                <p>
                    <i class="fas fa-tools"></i><strong>Équipements :</strong> 
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

        <!-- Avis Section -->
        <div class="professional-card p-4 p-md-5">
            <h3 class="title-font section-title" style="color: var(--bleu-fonce); font-size: 2rem; font-weight: 700;">Avis</h3>
            <div class="avis-grid">
                @if($listing->annonce && $listing->annonce->avis)
                    @forelse($listing->annonce->avis as $avis)
                        <div class="avis-card">
                            <img src="{{ $avis->locataire->photodeprofil_uti ? asset('storage/' . $avis->locataire->photodeprofil_uti) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $avis->locataire->prenom ?? 'Utilisateur' }}">
                            <div class="avis-card-content">
                                <h6>{{ $avis->locataire->prenom ?? '' }} {{ $avis->locataire->nom_uti ?? '' }}</h6>
                                <small class="date">{{ $avis->created_at->format('D MMM YYYY, H:mm') }}</small>
                                <p>{{ $avis->contenu ?? '' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="no-content">
                            <i class="fas fa-comment-slash"></i>
                            <p>Aucun avis pour le moment.</p>
                        </div>
                    @endforelse
                @else
                    <div class="no-content">
                        <i class="fas fa-comment-slash"></i>
                        <p>Aucun avis pour le moment.</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="professional-card">
            <div class="no-content">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Aucun logement trouvé. <a href="{{ route('proprietaire.logements') }}" class="back-btn">Retour à la liste</a></p>
            </div>
        </div>
    @endif
</div>

@endsection