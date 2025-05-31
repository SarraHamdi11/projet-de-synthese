@extends('layouts.app')

@section('title', 'Réservation - FindStay')

@section('content')
<div class="container">

<h2>Réservation pour {{ $listing->type_log }} à {{ $listing->ville }}</h2>
<p><strong>Prix :</strong> {{ $listing->prix_log }} MAD</p>
<p><strong>Localisation :</strong> {{ $listing->localisation_log }}</p>
<p><strong>Date de création :</strong> {{ $listing->date_creation_log }}</p>
<p><strong>Nombre de colocataires autorisés :</strong> {{ $listing->nombre_colocataire_log }}</p>
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
@if($listing->photos)
    <div><strong>Photos :</strong><br>
        @foreach(json_decode($listing->photos, true) as $photo)
            @php $photoPath = 'images/' . $photo; @endphp
            @if(file_exists(public_path($photoPath)))
                <img src="{{ asset($photoPath) }}" alt="Photo du logement" style="max-width:150px; margin:5px;">
            @else
                <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut" style="max-width:150px; margin:5px;">
            @endif
        @endforeach
    </div>
@endif

<div class="reservation-form">
    <form action="{{ route('storeReservation') }}" method="POST">
        @csrf
        <input type="hidden" name="listing_id" value="{{ $listing->id }}">
        <input type="hidden" name="type" value="{{ $listing->type_log }}">
        <input type="hidden" name="title" value="{{ $listing->type_log }} à {{ $listing->ville }}">

    

            
            <div class="form-group">
                <label for="start_date">Date de début</label>
                <input type="date" id="start_date" name="start_date" required class="form-control">
            </div>
            
            <div class="form-group">
                <label for="end_date">Date de fin</label>
                <input type="date" id="end_date" name="end_date" required class="form-control">
            </div>
            
            <div class="form-group">
                <label for="colocataires">Nombre de colocataires</label>
                <select id="colocataires" name="colocataires" required class="form-control">
                    <option value="1">1 personne</option>
                    <option value="2">2 personnes</option>
                    <option value="3">3 personnes</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Confirmer la réservation</button>
        </form>
    </div>
</div>

<style>
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.reservation-form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn-primary {
    background: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary:hover {
    background: #0056b3;
}
</style>
@endsection