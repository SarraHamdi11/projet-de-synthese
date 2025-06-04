@extends('layouts.app')

@section('title', 'Détails du logement - FindStay')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .title-font {
        font-family: 'Inknut Antiqua', serif;
    }

    .professional-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(36, 79, 118, 0.08);
        border: 1px solid rgba(36, 79, 118, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .professional-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(36, 79, 118, 0.15);
    }

    .form-control:focus, .form-select:focus {
        border-color: #447892;
        box-shadow: 0 0 0 0.2rem rgba(68, 120, 146, 0.25);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #447892 0%, #244F76 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(68, 120, 146, 0.3);
    }

    .btn-success-custom {
        background: linear-gradient(135deg, #21825C 0%, #1a6b4a 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-success-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(33, 130, 92, 0.3);
    }

    .btn-outline-primary-custom {
        border: 2px solid #447892;
        color: #244F76;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-primary-custom:hover {
        background: #447892;
        color: white;
        transform: translateY(-2px);
    }

    .btn-outline-primary-custom.active {
        background: #447892;
        color: white;
    }

    .form-label {
        font-weight: 600;
        color: #244F76;
        margin-bottom: 8px;
    }

    .form-control {
        border: 2px solid rgba(36, 79, 118, 0.2);
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .form-control:hover {
        border-color: #7C9FC0;
    }

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 40px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #447892 0%, #244F76 100%);
        border-radius: 2px;
    }

    .listing-detail {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        font-size: 1rem;
    }

    .listing-detail i {
        color: #447892;
        margin-right: 10px;
    }

    .listing-detail span {
        color: #244F76;
        font-weight: 500;
    }

    .equipments-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .equipment-badge {
        background: rgba(124, 159, 192, 0.1);
        color: #244F76;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .carousel-inner {
        border-radius: 15px;
        overflow: hidden;
    }

    .avatar-circle {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 2px solid rgba(36, 79, 118, 0.1);
    }

    .avatar-circle-small {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border: 2px solid rgba(36, 79, 118, 0.1);
    }
</style>

<div class="container mx-auto px-4 py-5">
    <div class="text-center mb-5">
        <h2 class="title-font section-title" style="color:#244F76; font-weight:700; font-size:2.5rem;">
            {{ $logement->type_log }} à {{ $logement->ville }}
        </h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">
            Découvrez les détails de ce logement
        </p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="professional-card p-4 p-md-5 mb-4">
                @if($logement->photos)
                    @php
                        $photos = json_decode($logement->photos, true);
                    @endphp
                    <div class="mb-5">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($photos as $index => $photo)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset($photo) }}" class="d-block w-100" alt="Photo du logement" style="height: 400px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            @if(count($photos) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <h3 class="title-font mb-4" style="color:#244F76; font-weight:600; font-size:1.8rem;">
                        Détails du logement
                    </h3>
                    <div class="listing-detail">
                        <i class="fas fa-coins"></i>
                        <span><strong>Prix :</strong> {{ $logement->prix_log }} MAD/mois</span>
                    </div>
                    <div class="listing-detail">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><strong>Localisation :</strong> {{ $logement->localisation_log }}</span>
                    </div>
                    <div class="listing-detail">
                        <i class="fas fa-home"></i>
                        <span><strong>Type :</strong> {{ $logement->type_log }}</span>
                    </div>
                    <div class="listing-detail">
                        <i class="fas fa-users"></i>
                        <span><strong>Nombre de colocataires :</strong> {{ $logement->nombre_colocataire_log }}</span>
                    </div>
                    @if($logement->etage)
                        <div class="listing-detail">
                            <i class="fas fa-building"></i>
                            <span><strong>Étage :</strong> {{ $logement->etage }}</span>
                        </div>
                    @endif
                    @if($logement->equipements)
                        <div class="listing-detail">
                            <i class="fas fa-tools"></i>
                            <span><strong>Équipements :</strong></span>
                            <div class="equipments-list ms-2">
                                @foreach(json_decode($logement->equipements, true) as $equipement)
                                    <span class="equipment-badge">{{ $equipement }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Avis Section -->
            <div class="professional-card p-4 p-md-5 mt-4">
                <h3 class="title-font mb-4" style="color:#244F76; font-weight:600; font-size:1.8rem;">
                    Avis
                </h3>
                <div class="avis-list">
                    @forelse($logement->annonce->avis as $avis)
                        <div class="avis mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ $avis->locataire->photodeprofil_uti ? asset($avis->locataire->photodeprofil_uti) : asset('images/default-avatar.png') }}" 
                                     alt="{{ $avis->locataire->prenom }}" 
                                     class="rounded-circle me-2 avatar-circle-small">
                                <div>
                                    <h6 class="mb-0" style="color:#244F76;">{{ $avis->locataire->prenom }} {{ $avis->locataire->nom_uti }}</h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($avis->created_at)->isoFormat('D MMM YYYY') }}</small>
                                </div>
                            </div>
                            <p class="mb-0 text-muted">{{ $avis->contenu }}</p>
                        </div>
                    @empty
                        <div class="text-center">
                            <i class="fas fa-comment-slash" style="font-size: 3rem; color: #7C9FC0; opacity: 0.5;"></i>
                            <p class="text-muted mt-3">Aucun avis pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="professional-card p-4 p-md-5 mb-4">
                <h3 class="title-font mb-4" style="color:#244F76; font-weight:600; font-size:1.8rem;">
                    Propriétaire
                </h3>
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ $proprietaire->photodeprofil_uti ? asset($proprietaire->photodeprofil_uti) : asset('images/default-avatar.png') }}" 
                         alt="{{ $proprietaire->prenom }}" 
                         class="rounded-circle me-3 avatar-circle">
                    <div>
                        <h5 class="mb-1" style="color:#244F76; font-weight:600;">{{ $proprietaire->prenom }} {{ $proprietaire->nom_uti }}</h5>
                        <p class="text-muted mb-0">Propriétaire</p>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('conversations.show', $proprietaire->id) }}" class="btn btn-primary-custom">
                        <i class="fas fa-envelope me-2"></i>Contacter le propriétaire
                    </a>
                    <a href="{{ route('showReservation', $logement->id) }}" class="btn btn-success-custom">
                        <i class="fas fa-calendar-check me-2"></i>Réserver
                    </a>
                    <button class="btn btn-outline-primary-custom toggle-favorite" data-listing-id="{{ $logement->id }}">
                        <i class="fas fa-heart me-2"></i>Ajouter aux favoris
                    </button>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="professional-card p-4 p-md-5">
                <h3 class="title-font mb-4" style="color:#244F76; font-weight:600; font-size:1.8rem;">
                    Commentaires
                </h3>
                
                <!-- Comment Form -->
                <form action="{{ route('storeComment', $logement->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label for="comment" class="form-label">
                            <i class="fas fa-comment me-2"></i>Votre commentaire
                        </label>
                        <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Écrivez votre commentaire..."></textarea>
                        @error('comment')
                            <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-paper-plane me-2"></i>Publier
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle favorite functionality
    const favoriteBtn = document.querySelector('.toggle-favorite');
    if (favoriteBtn) {
        favoriteBtn.addEventListener('click', function() {
            const listingId = this.dataset.listingId;
            fetch(`/locataire/favorite/${listingId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.classList.toggle('active');
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fas');
                    icon.classList.toggle('far');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});
</script>
@endpush

@endsection