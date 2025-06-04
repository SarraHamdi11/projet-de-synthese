@extends('layouts.app')

@section('title', 'Réservation - FindStay')

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

    .form-label {
        font-weight: 600;
        color: #244F76;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 2px solid rgba(36, 79, 118, 0.2);
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .form-control:hover, .form-select:hover {
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

    .photos-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .photos-gallery img {
        border-radius: 10px;
        object-fit: cover;
        width: 150px;
        height: 150px;
        border: 2px solid rgba(36, 79, 118, 0.1);
    }
</style>

<div class="container mx-auto px-4 py-5">
    <div class="text-center mb-5">
        <h2 class="title-font section-title" style="color:#244F76; font-weight:700; font-size:2.5rem;">
            Réservation pour {{ $listing->type_log }} à {{ $listing->ville }}
        </h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">
            Finalisez votre réservation en quelques étapes
        </p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="professional-card p-4 p-md-5">
                <div class="mb-5">
                    <h4 class="title-font mb-4" style="color:#244F76; font-weight:600; font-size:1.8rem;">
                        Détails du logement
                    </h4>
                    <div class="listing-detail">
                        <i class="fas fa-coins"></i>
                        <span><strong>Prix :</strong> {{ $listing->prix_log }} MAD/mois</span>
                    </div>
                    <div class="listing-detail">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><strong>Localisation :</strong> {{ $listing->localisation_log }}</span>
                    </div>
                    <div class="listing-detail">
                        <i class="fas fa-calendar-alt"></i>
                        <span><strong>Date de création :</strong> {{ \Carbon\Carbon::parse($listing->date_creation_log)->isoFormat('D MMM YYYY') }}</span>
                    </div>
                    <div class="listing-detail">
                        <i class="fas fa-users"></i>
                        <span><strong>Nombre de colocataires autorisés :</strong> {{ $listing->nombre_colocataire_log }}</span>
                    </div>
                    <div class="listing-detail">
                        <i class="fas fa-building"></i>
                        <span><strong>Étage :</strong> {{ $listing->etage ?? 'N/A' }}</span>
                    </div>
                    <div class="listing-detail">
                        <i class="fas fa-tools"></i>
                        <span><strong>Équipements :</strong></span>
                        @if($listing->equipements)
                            <div class="equipments-list ms-2">
                                @foreach(json_decode($listing->equipements, true) as $equipement)
                                    <span class="equipment-badge">{{ $equipement }}</span>
                                @endforeach
                            </div>
                        @else
                            <span class="ms-2">Aucun</span>
                        @endif
                    </div>
                    @if($listing->photos)
                        <div class="listing-detail">
                            <i class="fas fa-camera"></i>
                            <span><strong>Photos :</strong></span>
                            <div class="photos-gallery">
                                @foreach(json_decode($listing->photos, true) as $photo)
                                    @php $photoPath = 'images/' . $photo; @endphp
                                    @if(file_exists(public_path($photoPath)))
                                        <img src="{{ asset($photoPath) }}" alt="Photo du logement">
                                    @else
                                        <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="reservation-form">
                    <h4 class="title-font mb-4" style="color:#244F76; font-weight:600; font-size:1.8rem;">
                        Formulaire de réservation
                    </h4>
                    <form action="{{ route('storeReservation') }}" method="POST">
                        @csrf
                        <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                        <input type="hidden" name="type" value="{{ $listing->type_log }}">
                        <input type="hidden" name="title" value="{{ $listing->type_log }} à {{ $listing->ville }}">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-2"></i>Date de début
                                </label>
                                <input type="date" id="start_date" name="start_date" required class="form-control" min="{{ now()->format('Y-m-d') }}">
                                @error('start_date')
                                    <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="end_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-2"></i>Date de fin
                                </label>
                                <input type="date" id="end_date" name="end_date" required class="form-control" min="{{ now()->addDay()->format('Y-m-d') }}">
                                @error('end_date')
                                    <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="colocataires" class="form-label">
                                    <i class="fas fa-users me-2"></i>Nombre de colocataires
                                </label>
                                <select id="colocataires" name="colocataires" required class="form-select">
                                    @for($i = 1; $i <= $listing->nombre_colocataire_log; $i++)
                                        <option value="{{ $i }}">{{ $i }} personne{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                                @error('colocataires')
                                    <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary-custom btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Confirmer la réservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection