@extends('layouts.app')

@section('title', 'Profil locataire')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <a href="{{ route('locataire.myprofile') }}">
            <img src="{{ $locataire->photodeprofil_uti ? asset('storage/' . $locataire->photodeprofil_uti) : asset('images/default-avatar.png') }}" alt="Photo de profil" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 2px solid #24507a;">
        </a>
        <h1>Bonjour {{ $locataire->prenom }} {{ $locataire->nom_uti }}</h1>
        <p>Tél: {{ $locataire->tel_uti }}</p>
        <p>Email: {{ $locataire->email_uti }}</p>
        <p>Rôle: {{ $locataire->role_uti }}</p>
        <p>Date de naissance: {{ $locataire->date_naissance }}</p>
    </div>

    <div class="activities">
        <h2>Les activités de {{ $locataire->prenom }} {{ $locataire->nom_uti }}</h2>
        @if($avis->isNotEmpty())
            @foreach($avis as $av)
                <div class="activity">
                    <img src="{{ asset('images/WhatsApp Image 2025-05-09 à 21.06.44_64fe0eec.jpg') }}" alt="Photo de profil">
                    <div>
                        <p><strong>{{ $locataire->prenom }} {{ $locataire->nom_uti }}</strong> - {{ $av->created_at }}</p>
                        <p>Note: {{ $av->note }}/5 - Commentaire: {{ $av->contenu }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <p>Aucun commentaire trouvé.</p>
        @endif
    </div>

    <div class="reservations">
        <h2>Mes réservations</h2>
        @foreach($reservations as $reservation)
        <div class="reservation">
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
                    <span class="status">{{ $reservation->status ?? 'N/A' }}</span>
                    <span class="date">{{ $reservation->created_at ? $reservation->created_at->format('d/m/Y') : '' }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    :root {
        --bleu-fonce: #244F76;
        --bleu-moyen: #447892;
        --bleu-clair: #7C9FC0;
        --creme: #EBDFD5;
        --blanc: #fff;
    }
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: var(--blanc);
        margin: 0;
        padding: 0;
    }
    .profile-header h1 {
        color: var(--bleu-fonce);
    }
    .stats {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 20px 0;
    }
    .stat-card {
        background-color: var(--creme);
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 4px var(--bleu-clair);
        width: 140px;
    }
    .stat-card h4 {
        margin-bottom: 5px;
        font-size: 14px;
        color: var(--bleu-moyen);
    }
    .stat-card p {
        font-size: 24px;
        font-weight: bold;
        color: var(--bleu-fonce);
    }
    .profile-info {
        background-color: var(--creme);
        padding: 20px;
        border-radius: 12px;
        margin: 0 auto 30px;
        width: 320px;
        box-shadow: 0 2px 4px var(--bleu-clair);
        font-size: 14px;
        color: var(--bleu-fonce);
        border: 1.5px solid var(--bleu-clair);
    }
    .profile-info p {
        margin: 4px 0;
    }
    .reservations {
        max-width: 700px;
        margin: 0 auto;
        padding-bottom: 50px;
    }
    .reservations h2 {
        text-align: center;
        font-size: 22px;
        color: var(--bleu-fonce);
        margin-bottom: 20px;
    }
    .reservation {
        display: flex;
        background-color: var(--blanc);
        margin-bottom: 20px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px var(--bleu-clair);
        border: 1.5px solid var(--creme);
    }
    .reservation img {
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
        font-size: 18px;
    }
    .reservation-content p {
        margin: 0 0 12px;
        color: var(--bleu-moyen);
        font-size: 15px;
    }
    .reservation-footer {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .reservation-footer .date {
        font-size: 0.95em;
        color: var(--bleu-clair);
    }
    .reservation-footer .status {
        font-size: 1.1em;
        color: var(--bleu-moyen);
        background: var(--creme);
        border-radius: 8px;
        padding: 2px 10px;
    }
</style>
@endsection 