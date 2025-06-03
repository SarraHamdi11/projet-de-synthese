@extends('layouts.app')

@section('title', 'Profil Propriétaire')

@section('content')
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
    .publications {
        max-width: 700px;
        margin: 0 auto;
        padding-bottom: 50px;
    }
    .publications h2 {
        text-align: center;
        font-size: 22px;
        color: var(--bleu-fonce);
        margin-bottom: 20px;
    }
    .publication {
        display: flex;
        background-color: var(--blanc);
        margin-bottom: 20px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px var(--bleu-clair);
        border: 1.5px solid var(--creme);
    }
    .publication img {
        width: 140px;
        height: 110px;
        object-fit: cover;
        background: var(--creme);
    }
    .publication-content {
        padding: 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .publication-content h3 {
        margin: 0 0 8px;
        color: var(--bleu-fonce);
        font-size: 18px;
    }
    .publication-content p {
        margin: 0 0 12px;
        color: var(--bleu-moyen);
        font-size: 15px;
    }
    .publication-footer {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .publication-footer .comments {
        display: flex;
        align-items: center;
        font-size: 1.1em;
        color: var(--bleu-moyen);
        background: var(--creme);
        border-radius: 8px;
        padding: 2px 10px;
    }
    .publication-footer .comments i {
        margin-right: 4px;
    }
    .publication-footer .date {
        font-size: 0.95em;
        color: var(--bleu-clair);
    }
</style>

<div class="profile-header">
    <a href="{{ route('proprietaire.myprofile') }}">
        <img src="{{ $proprietaire->photodeprofil_uti ? asset('storage/' . $proprietaire->photodeprofil_uti) : asset('images/default-avatar.png') }}" alt="Photo de profil" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 2px solid #24507a;">
    </a>
    <h1>Bonjour {{ $proprietaire->prenom ?? '' }} {{ $proprietaire->nom_uti ?? '' }}</h1>
</div>

<div class="stats">
    <div class="stat-card">
        <h4>Les annonces</h4>
        <p>{{ $annoncesCount }}</p>
    </div>
    <div class="stat-card">
        <h4>Commentaires</h4>
        <p>{{ $commentairesCount }}</p>
    </div>
</div>

<div class="profile-info">
    <p><strong>{{ $proprietaire->prenom ?? '' }} {{ $proprietaire->nom_uti ?? '' }}</strong></p>
    <p>Tél: {{ $proprietaire->tel_uti ?? '' }}</p>
    <p>{{ $proprietaire->email ?? '' }}</p>
    <p>Role: {{ $proprietaire->role_uti ?? '' }}</p>
    <p>Ville: {{ $proprietaire->ville ?? '' }}</p>
    <p>Date de naissance: {{ $proprietaire->date_naissance ?? '' }}</p>
</div>

<div class="publications">
    <h2>Les publications</h2>
    @forelse($annonces as $annonce)
    <div class="publication">
        <img src="{{ $annonce->logement->photos ? asset(json_decode($annonce->logement->photos)[0]) : asset('images/default-avatar.png') }}" alt="Photo">
        <div class="publication-content">
            <div>
                <h3>{{ $annonce->titre_anno ?? 'Sans titre' }}</h3>
                <p>{{ $annonce->description_anno ?? 'Aucune description' }}</p>
            </div>
            <div class="publication-footer">
                <span class="comments">
                    <i class="far fa-comment-dots"></i>
                    {{ $annonce->avis->count() ?? 0 }}
                </span>
                <span class="date">{{ $annonce->date_publication_anno ? $annonce->date_publication_anno->format('d/m/Y') : 'Date inconnue' }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="no-publications">
        <p>Aucune publication trouvée.</p>
    </div>
    @endforelse
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.property-card').hover(
            function() {
                $(this).find('.actions-btn').css('opacity', '1');
            },
            function() {
                $(this).find('.actions-btn').css('opacity', '0.7');
            }
        );
    });
</script>
@endsection 