@extends('layouts.app')

@section('title', 'Profil locataire')

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

    .avatar-circle {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--bleu-fonce);
        transition: transform 0.3s ease;
    }

    .avatar-circle:hover {
        transform: scale(1.05);
    }

    .avatar-circle-small {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--bleu-clair);
    }

    .profile-header {
        text-align: center;
        padding: 30px 20px;
    }

    .profile-header h1 {
        color: var(--bleu-fonce);
        font-size: 2rem;
        font-weight: 700;
        margin-top: 20px;
    }

    .profile-detail {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        font-size: 0.95rem;
        color: var(--bleu-fonce);
    }

    .profile-detail i {
        color: var(--bleu-moyen);
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .activity-card {
        display: flex;
        align-items: center;
        background: var(--blanc);
        border-radius: 16px;
        border: 1.5px solid var(--creme);
        padding: 16px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .activity-card:hover {
        border-color: var(--bleu-clair);
        box-shadow: 0 10px 30px rgba(36, 79, 118, 0.1);
        transform: translateY(-3px);
    }

    .activity-card-content {
        margin-left: 15px;
        flex-grow: 1;
    }

    .activity-card-content p {
        margin: 0;
        color: var(--bleu-fonce);
    }

    .activity-card-content .date {
        color: var(--bleu-clair);
        font-size: 0.9rem;
    }

    .activity-card-content .note {
        color: var(--bleu-moyen);
        font-weight: 600;
    }

    .reservation-card {
        display: flex;
        background: var(--blanc);
        border-radius: 16px;
        border: 1.5px solid var(--creme);
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .reservation-card:hover {
        border-color: var(--bleu-clair);
        box-shadow: 0 10px 30px rgba(36, 79, 118, 0.1);
        transform: translateY(-3px);
    }

    .reservation-card img {
        width: 140px;
        height: 110px;
        object-fit: cover;
        background: var(--creme);
    }

    .reservation-content {
        padding: 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .reservation-content h3 {
        margin: 0 0 8px;
        color: var(--bleu-fonce);
        font-size: 1.2rem;
        font-weight: 600;
    }

    .reservation-content p {
        margin: 0 0 12px;
        color: var(--bleu-moyen);
        font-size: 0.95rem;
    }

    .reservation-footer {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .reservation-footer .date {
        font-size: 0.9rem;
        color: var(--bleu-clair);
    }

    .reservation-footer .status {
        font-size: 1rem;
        color: var(--bleu-moyen);
        background: var(--creme);
        border-radius: 8px;
        padding: 4px 12px;
        font-weight: 600;
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

    .sidebar-profile {
        position: sticky;
        top: 20px;
    }
</style>

<div class="container mx-auto px-4 py-5">
    <div class="row">
        <!-- Sidebar Profile -->
        <div class="col-md-4 mb-4">
            <div class="professional-card sidebar-profile">
                <div class="profile-header">
                    <a href="{{ route('locataire.myprofile') }}">
                        <img src="{{ $locataire->photodeprofil_uti ? asset('storage/' . $locataire->photodeprofil_uti) : asset('images/default-avatar.png') }}" alt="Photo de profil" class="avatar-circle">
                    </a>
                    <h1 class="title-font">Bonjour {{ $locataire->prenom }} {{ $locataire->nom_uti }}</h1>
                    <div class="profile-detail">
                        <i class="fas fa-phone-alt"></i>
                        <span>Tél : {{ $locataire->tel_uti }}</span>
                    </div>
                    <div class="profile-detail">
                        <i class="fas fa-envelope"></i>
                        <span>Email : {{ $locataire->email_uti }}</span>
                    </div>
                    <div class="profile-detail">
                        <i class="fas fa-user-tag"></i>
                        <span>Rôle : {{ $locataire->role_uti }}</span>
                    </div>
                    <div class="profile-detail">
                        <i class="fas fa-birthday-cake"></i>
                        <span>Date de naissance : {{ \Carbon\Carbon::parse($locataire->date_naissance)->isoFormat('D MMM YYYY') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
            <!-- Activities Section -->
            <div class="activities mb-5">
                <h2 class="title-font section-title" style="color: var(--bleu-fonce); font-size: 2rem; font-weight: 700;">
                    Mes activités
                </h2>
                <div class="professional-card p-4 p-md-5">
                    @if($avis->isNotEmpty())
                        @foreach($avis as $av)
                            <div class="activity-card">
                                <img src="{{ asset('images/WhatsApp Image 2025-05-09 à 21.06.44_64fe0eec.jpg') }}" alt="Photo de profil" class="avatar-circle-small">
                                <div class="activity-card-content">
                                    <p><strong>{{ $locataire->prenom }} {{ $locataire->nom_uti }}</strong> <span class="date">- {{ \Carbon\Carbon::parse($av->created_at)->isoFormat('D MMM YYYY') }}</span></p>
                                    <p><span class="note">Note : {{ $av->note }}/5</span> - Commentaire : {{ $av->contenu }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-content">
                            <i class="fas fa-comment-slash"></i>
                            <p>Aucun commentaire trouvé.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reservations Section -->
            <div class="reservations">
                <h2 class="title-font section-title" style="color: var(--bleu-fonce); font-size: 2rem; font-weight: 700;">
                    Mes réservations
                </h2>
                <div class="professional-card p-4 p-md-5">
                    @if($reservations->isNotEmpty())
                        @foreach($reservations as $reservation)
                            <div class="reservation-card">
                                @if($reservation->logments && $reservation->logments->annonce && $reservation->logments->annonce->image)
                                    <img src="{{ asset('storage/' . $reservation->logments->annonce->image) }}" alt="Photo">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="Photo">
                                @endif
                                <div class="reservation-content">
                                    <div>
                                        <h3>{{ $reservation->logments && $reservation->logments->annonce ? $reservation->logments->annonce->titre : 'Titre non disponible' }}</h3>
                                        <p>{{ $reservation->logments && $reservation->logments->annonce ? $reservation->logments->annonce->description : 'Description non disponible' }}</p>
                                    </div>
                                    <div class="reservation-footer">
                                        <span class="date">{{ $reservation->created_at ? \Carbon\Carbon::parse($reservation->created_at)->isoFormat('D MMM YYYY') : '' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-content">
                            <i class="fas fa-calendar-times"></i>
                            <p>Aucune réservation trouvée.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection