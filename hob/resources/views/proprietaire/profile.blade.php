@extends('layout')

@section('title', 'Profil Propriétaire')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f9fafb;
        margin: 0;
        padding: 0;
    }


    

    .stats {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 20px 0;
    }

    .stat-card {
        background-color: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 140px;
    }

    .stat-card h4 {
        margin-bottom: 5px;
        font-size: 14px;
        color: #4a5568;
    }

    .stat-card p {
        font-size: 24px;
        font-weight: bold;
        color: #2d3748;
    }

    .profile-info {
        background-color: #f3f4f6;
        padding: 20px;
        border-radius: 12px;
        margin: 0 auto 30px;
        width: 320px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-size: 14px;
        color: #4a5568;
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
        font-size: 20px;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .publication {
        display: flex;
        background-color:rgb(246, 231, 209);
        margin-bottom: 20px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .publication img {
        width: 200px;
        height: 150px;
        object-fit: cover;
    }

    .publication-content {
        padding: 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .publication-content h3 {
        margin: 0 0 10px;
        color: #2a4365;
        font-size: 16px;
    }

    .publication-content p {
        margin: 0 0 10px;
        color: #4a5568;
        font-size: 14px;
    }

    .publication-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: #718096;
    }

    .publication-footer i {
        margin-right: 4px;
    }
</style>

<div class="profile-header">
    <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg" alt="Photo de profil">
    <h1>Bonjour {{ $proprietaire->nom }}</h1>
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
    <p><strong>{{ $proprietaire->nom }}</strong></p>
    <p>Tél: {{ $proprietaire->telephone }}</p>
    <p>{{ $proprietaire->email }}</p>
    <p>Role: {{ $proprietaire->role }}</p>
    <p>Ville: {{ $proprietaire->ville }}</p>
    <p>Date de naissance: {{ $proprietaire->date_naissance }}</p>
</div>

<div class="publications">
    <h2>Les publications</h2>
    @foreach($annonces as $annonce)
    <div class="publication">
        <img src="{{ $annonce['image'] }}" alt="Photo">
        <div class="publication-content">
            <div>
                <h3>{{ $annonce['titre'] }}</h3>
                <p>{{ $annonce['description'] }}</p>
            </div>
           
        </div>
    </div>
    @endforeach
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
