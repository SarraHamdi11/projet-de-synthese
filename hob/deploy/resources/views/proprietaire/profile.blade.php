@extends('layout')

@section('title', 'Profil Propriétaire')

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

    .stat-card {
        background-color: var(--creme);
        padding: 15px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 4px var(--bleu-clair);
        width: 100%;
        margin-bottom: 15px;
    }

    .stat-card h4 {
        margin-bottom: 5px;
        font-size: 14px;
        color: var(--bleu-moyen);
    }

    .stat-card p {
        font-size: 20px;
        font-weight: 600;
        color: var(--bleu-fonce);
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

    .publication-card {
        display: flex;
        background: var(--blanc);
        border-radius: 16px;
        border: 1.5px solid var(--creme);
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .publication-card:hover {
        border-color: var(--bleu-clair);
        box-shadow: 0 10px 30px rgba(36, 79, 118, 0.1);
        transform: translateY(-3px);
    }

    .publication-card img {
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
        font-size: 1.2rem;
        font-weight: 600;
    }

    .publication-content p {
        margin: 0 0 12px;
        color: var(--bleu-moyen);
        font-size: 0.95rem;
    }

    .publication-footer {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .publication-footer .date {
        font-size: 0.9rem;
        color: var(--bleu-clair);
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
</style>

<div class="container mx-auto px-4 py-5">
    <div class="row">
        <!-- Sidebar Profile -->
        <div class="col-md-4 mb-4">
            <div class="professional-card sidebar-profile">
                <div class="profile-header">
                    <h2 class="title-font section-title" style="color: var(--bleu-fonce); font-size: 2rem; font-weight: 700;">
                        Profil de {{ $proprietaire->nom ?? '' }}
                    </h2>
                    <a href="{{ route('proprietaire.myprofile') }}">
                        <img src="{{ $proprietaire->photodeprofil_uti ? asset('storage/' . $proprietaire->photodeprofil_uti) : 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg' }}" alt="Photo de profil" class="avatar-circle">
                    </a>
                    <h1 class="title-font">Bonjour {{ $proprietaire->nom ?? '' }}</h1>
                </div>

                <div class="p-4">
                    <div class="stats">
                        <div class="stat-card">
                            <h4>Les annonces</h4>
                            <p>{{ $annoncesCount ?? 0 }}</p>
                        </div>
                        <div class="stat-card">
                            <h4>Commentaires</h4>
                            <p>{{ $commentairesCount ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="profile-detail">
                            <i class="fas fa-phone-alt"></i>
                            <span>Tél : {{ $proprietaire->telephone ?? '' }}</span>
                        </div>
                        <div class="profile-detail">
                            <i class="fas fa-envelope"></i>
                            <span>Email : {{ $proprietaire->email ?? '' }}</span>
                        </div>
                        <div class="profile-detail">
                            <i class="fas fa-user-tag"></i>
                            <span>Rôle : {{ $proprietaire->role ?? '' }}</span>
                        </div>
                        <div class="profile-detail">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Ville : {{ $proprietaire->ville ?? '' }}</span>
                        </div>
                        <div class="profile-detail">
                            <i class="fas fa-birthday-cake"></i>
                            <span>Date de naissance : {{ \Carbon\Carbon::parse($proprietaire->date_naissance ?? now())->isoFormat('D MMM YYYY') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
            <div class="publications">
                <h2 class="title-font section-title" style="color: var(--bleu-fonce); font-size: 2rem; font-weight: 700;">
                    Mes publications
                </h2>
                <div class="professional-card p-4 p-md-5">
                    @if(!empty($annonces) && is_array($annonces))
                        @foreach($annonces as $annonce)
                            <div class="publication-card">
                                <img src="{{ $annonce['image'] ?? asset('images/default-avatar.png') }}" alt="Photo">
                                <div class="publication-content">
                                    <div>
                                        <h3>{{ $annonce['titre'] ?? 'Sans titre' }}</h3>
                                        <p>{{ $annonce['description'] ?? 'Aucune description' }}</p>
                                    </div>
                                    <div class="publication-footer">
                                        <span class="date">{{ now()->isoFormat('D MMM YYYY') }}</span> <!-- Date simulée, à remplacer par une date réelle si disponible -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-content">
                            <i class="fas fa-newspaper"></i>
                            <p>Aucune publication trouvée.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Script supprimé car pas d'actions-btn dans la page locataire -->
@endsection