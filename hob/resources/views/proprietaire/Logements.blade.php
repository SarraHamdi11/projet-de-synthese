@extends('layouts.app')

@section('title', 'Logements - FindStay')

@section('content')
    <div class="container">
        <div class="filters">
            <form method="GET" action="{{ route('proprietaire.logements') }}">
                <div class="filter-section">
                    <h3>Prix</h3>
                    <div class="price-range">
                        <input type="number" name="min_price" placeholder="Min" value="{{ request()->input('min_price') }}">
                        <input type="number" name="max_price" placeholder="Max" value="{{ request()->input('max_price') }}">
                    </div>
                </div>
                <div class="filter-section">
                    <h3>Type de recherche</h3>
                    <label><input type="checkbox" name="search_type[]" value="logement" {{ in_array('logement', request()->input('search_type', [])) ? 'checked' : '' }}> Logement</label>
                    <label><input type="checkbox" name="search_type[]" value="colocation" {{ in_array('colocation', request()->input('search_type', [])) ? 'checked' : '' }}> Colocation</label>
                </div>
                <div class="filter-section">
                    <h3>Type de logement</h3>
                    <label><input type="checkbox" name="logement_type[]" value="Studio" {{ in_array('Studio', request()->input('logement_type', [])) ? 'checked' : '' }}> Studio</label>
                    <label><input type="checkbox" name="logement_type[]" value="Appartement" {{ in_array('Appartement', request()->input('logement_type', [])) ? 'checked' : '' }}> Appartement</label>
                    <label><input type="checkbox" name="logement_type[]" value="Colocation" {{ in_array('Colocation', request()->input('logement_type', [])) ? 'checked' : '' }}> Colocation</label>
                </div>
                <div class="filter-section">
                    <h3>Nombre de colocataires</h3>
                    <label><input type="checkbox" name="colocataires[]" value="Solo" {{ in_array('Solo', request()->input('colocataires', [])) ? 'checked' : '' }}> Solo</label>
                    <label><input type="checkbox" name="colocataires[]" value="2" {{ in_array('2', request()->input('colocataires', [])) ? 'checked' : '' }}> 2</label>
                    <label><input type="checkbox" name="colocataires[]" value="3+" {{ in_array('3+', request()->input('colocataires', [])) ? 'checked' : '' }}> 3+</label>
                </div>
                <div class="filter-section">
                    <h3>Date d'emménagement</h3>
                    <input type="month" name="move_in_date" value="{{ request()->input('move_in_date', '2025-04') }}">
                </div>
                <div class="search-bar">
                    <input type="text" name="city" placeholder="Martil, colocation, non-fumeur" value="{{ request()->input('city') }}">
                    <button type="submit">🔍</button>
                </div>
            </form>
        </div>
        <div class="listings-grid">
            @forelse($filteredListings as $listing)
                <div class="listing-card">
                    <div class="listing-image">
                        @if($listing->photos)
                            @php $photos = json_decode($listing->photos, true); @endphp
                            @if(is_array($photos) && count($photos) > 0)
                                @foreach($photos as $photo)
                                    @php $photoPath = (substr($photo, 0, 7) === 'images/') ? $photo : 'images/' . $photo; @endphp
                                    <img src="{{ asset($photoPath) }}" alt="Photo du logement">
                                @endforeach
                            @else
                                <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut">
                            @endif
                        @else
                            <img src="{{ asset('images/default.jpg') }}" alt="Image par défaut">
                        @endif
                        <span class="favorite-icon">❤️</span>
                    </div>
                    <div class="listing-details">
                        <div class="listing-header">
                            <span class="listing-type">{{ $listing->type_log }}</span>
                            <span class="listing-price">{{ number_format($listing->prix_log, 0, ',', '.') }} MAD</span>
                        </div>
                        <p class="listing-city">{{ $listing->ville }}</p>
                        <p class="listing-description">
                            @if($listing->equipements)
                                @foreach(json_decode($listing->equipements, true) as $equipement)
                                    <span>{{ $equipement }}</span>@if(!$loop->last), @endif
                                @endforeach
                            @else
                                Aucun
                            @endif
                        </p>
                        <div class="listing-rating">
                            @for($i = 0; $i < 5; $i++)
                                <span class="star">★</span>
                            @endfor
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('proprietaire.details', $listing->id) }}" class="details-btn">DÉTAILS</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Aucun logement trouvé.</p>
            @endforelse
        </div>
        <div class="pagination">
            @if($page > 1)
                <a href="{{ route('proprietaire.logements', array_merge(request()->query(), ['page' => $page - 1])) }}">←</a>
            @endif
            @for($i = 1; $i <= ceil($total / $perPage); $i++)
                <a href="{{ route('proprietaire.logements', array_merge(request()->query(), ['page' => $i])) }}" class="{{ $i == $page ? 'active' : '' }}">{{ $i }}</a>
            @endfor
            @if($page < ceil($total / $perPage))
                <a href="{{ route('proprietaire.logements', array_merge(request()->query(), ['page' => $page + 1])) }}">→</a>
            @endif
        </div>
    </div>
@endsection

<style>
    .container {
        display: flex;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
        gap: 20px;
    }

    .filters {
        width: 250px;
        padding: 15px;
        background: #f5f5f5;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .filter-section {
        margin-bottom: 20px;
    }

    .filter-section h3 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
        text-transform: uppercase;
    }

    .filter-section label {
        display: block;
        margin: 8px 0;
        font-size: 14px;
        color: #666;
    }

    .price-range {
        display: flex;
        gap: 10px;
    }

    .price-range input,
    .filter-section input[type="month"],
    .search-bar input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .search-bar {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .search-bar input {
        flex-grow: 1;
    }

    .search-bar button {
        padding: 8px 15px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .listings-grid {
        flex-grow: 1;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .listing-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .listing-image {
        position: relative;
    }

    .listing-image img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .favorite-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        color: #e74c3c;
    }

    .listing-details {
        padding: 15px;
    }

    .listing-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .listing-type {
        font-size: 14px;
        font-weight: bold;
        color: #666;
        text-transform: uppercase;
    }

    .listing-price {
        font-size: 16px;
        font-weight: bold;
        color: #e74c3c;
    }

    .listing-city {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }

    .listing-description {
        font-size: 14px;
        color: #666;
        margin: 5px 0 10px;
        line-height: 1.4;
    }

    .listing-rating {
        margin-bottom: 10px;
    }

    .star {
        color: #ddd;
        font-size: 16px;
    }

    .star.filled {
        color: #f1c40f;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .details-btn {
        padding: 12px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: bold;
        text-transform: uppercase;
        background: #3498db;
        color: white;
        transition: all 0.3s ease;
    }

    .details-btn:hover {
        background: #2980b9;
    }

    .pagination {
        text-align: center;
        margin-top: 30px;
    }

    .pagination a {
        display: inline-block;
        padding: 8px 12px;
        margin: 0 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        color: #007bff;
        font-size: 14px;
        transition: background 0.3s;
    }

    .pagination a:hover {
        background: #f5f5f5;
    }

    .pagination a.active {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
    }
</style>