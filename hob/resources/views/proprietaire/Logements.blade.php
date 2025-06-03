@extends('layouts.app')

@section('title', 'Logements - FindStay')

@section('content')
    <div class="container-fluid bg-light min-vh-100 py-4">
        <div class="container">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold text-primary mb-1">Découvrez nos logements</h2>
                            <p class="text-muted mb-0">Trouvez votre logement idéal parmi notre sélection premium</p>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                <i class="fas fa-home me-1"></i>{{ $total }} logements
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Filters Sidebar -->
                <div class="col-lg-3">
                    <div class="card shadow-sm border-0 sticky-top filter-sidebar">
                        <div class="card-header bg-primary text-white border-0">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>Filtres de recherche
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <form method="GET" action="{{ route('proprietaire.logements') }}" class="needs-validation" novalidate>
                                
                                <!-- Search Bar -->
                                <div class="p-3 border-bottom bg-light">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               name="city" 
                                               class="form-control border-start-0 ps-0" 
                                               placeholder="Martil, colocation, non-fumeur" 
                                               value="{{ request()->input('city') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Price Range -->
                                <div class="p-3 border-bottom">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-tag me-2 text-primary"></i>Prix (MAD)
                                    </h6>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input type="number" 
                                                       name="min_price" 
                                                       class="form-control form-control-sm" 
                                                       id="minPrice"
                                                       placeholder="Min" 
                                                       value="{{ request()->input('min_price') }}">
                                                <label for="minPrice" class="form-label-sm">Min</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input type="number" 
                                                       name="max_price" 
                                                       class="form-control form-control-sm" 
                                                       id="maxPrice"
                                                       placeholder="Max" 
                                                       value="{{ request()->input('max_price') }}">
                                                <label for="maxPrice" class="form-label-sm">Max</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Search Type -->
                                <div class="p-3 border-bottom">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-search me-2 text-primary"></i>Type de recherche
                                    </h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="search_type[]" value="logement" 
                                               id="searchLogement" {{ in_array('logement', request()->input('search_type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="searchLogement">
                                            <i class="fas fa-home me-2 text-muted"></i>Logement
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="search_type[]" value="colocation" 
                                               id="searchColocation" {{ in_array('colocation', request()->input('search_type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="searchColocation">
                                            <i class="fas fa-users me-2 text-muted"></i>Colocation
                                        </label>
                                    </div>
                                </div>

                                <!-- Property Type -->
                                <div class="p-3 border-bottom">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-building me-2 text-primary"></i>Type de logement
                                    </h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="logement_type[]" value="Studio" 
                                               id="typeStudio" {{ in_array('Studio', request()->input('logement_type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="typeStudio">
                                            <i class="fas fa-door-open me-2 text-muted"></i>Studio
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="logement_type[]" value="Appartement" 
                                               id="typeAppartement" {{ in_array('Appartement', request()->input('logement_type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="typeAppartement">
                                            <i class="fas fa-building me-2 text-muted"></i>Appartement
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="logement_type[]" value="Colocation" 
                                               id="typeColocation" {{ in_array('Colocation', request()->input('logement_type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="typeColocation">
                                            <i class="fas fa-users me-2 text-muted"></i>Colocation
                                        </label>
                                    </div>
                                </div>

                                <!-- Roommates -->
                                <div class="p-3 border-bottom">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-user-friends me-2 text-primary"></i>Nombre de colocataires
                                    </h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="colocataires[]" value="Solo" 
                                               id="colocSolo" {{ in_array('Solo', request()->input('colocataires', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="colocSolo">
                                            <i class="fas fa-user me-2 text-muted"></i>Solo
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="colocataires[]" value="2" 
                                               id="coloc2" {{ in_array('2', request()->input('colocataires', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="coloc2">
                                            <i class="fas fa-users me-2 text-muted"></i>2
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="colocataires[]" value="3+" 
                                               id="coloc3plus" {{ in_array('3+', request()->input('colocataires', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="coloc3plus">
                                            <i class="fas fa-users me-2 text-muted"></i>3+
                                        </label>
                                    </div>
                                </div>

                                <!-- Move-in Date -->
                                <div class="p-3">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-calendar me-2 text-primary"></i>Date d'emménagement
                                    </h6>
                                    <input type="month" 
                                           name="move_in_date" 
                                           class="form-control" 
                                           value="{{ request()->input('move_in_date', '2025-04') }}">
                                </div>

                                <!-- Reset Button -->
                                <div class="p-3 pt-0">
                                    <button type="button" class="btn btn-outline-secondary w-100" onclick="this.form.reset();">
                                        <i class="fas fa-redo me-2"></i>Réinitialiser
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- Listings Grid -->
                <div class="col-lg-9">
                    <div class="row g-4" id="listingsContainer">
                        @forelse($filteredListings as $listing)
                            <div class="col-md-6 col-xl-4">
                                <div class="card h-100 shadow-sm border-0 listing-card position-relative overflow-hidden">
                                    <!-- Image Container -->
                                    <div class="position-relative overflow-hidden" style="height: 220px;">
                                        @if($listing->photos)
                                            @php $photos = json_decode($listing->photos, true); @endphp
                                            @if(is_array($photos) && count($photos) > 0)
                                                @foreach($photos as $index => $photo)
                                                    @php $photoPath = (substr($photo, 0, 7) === 'images/') ? $photo : 'images/' . $photo; @endphp
                                                    <img src="{{ asset($photoPath) }}" 
                                                         alt="Photo du logement" 
                                                         class="card-img-top w-100 h-100 object-fit-cover {{ $index > 0 ? 'd-none' : '' }}"
                                                         style="transition: transform 0.3s ease;">
                                                @endforeach
                                            @else
                                                <img src="{{ asset('images/default.jpg') }}" 
                                                     alt="Image par défaut" 
                                                     class="card-img-top w-100 h-100 object-fit-cover">
                                            @endif
                                        @else
                                            <img src="{{ asset('images/default.jpg') }}" 
                                                 alt="Image par défaut" 
                                                 class="card-img-top w-100 h-100 object-fit-cover">
                                        @endif
                                        
                                        <!-- Overlay Gradient -->
                                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-to-bottom opacity-0 hover-overlay"></div>
                                        
                                        <!-- Favorite Button -->
                                        <button class="btn btn-sm position-absolute top-0 end-0 m-2 border-0 bg-white bg-opacity-75 rounded-circle p-2 favorite-btn">
                                            <i class="fas fa-heart text-danger"></i>
                                        </button>
                                        
                                        <!-- Property Type Badge -->
                                        <span class="badge bg-primary position-absolute bottom-0 start-0 m-2 px-3 py-2 rounded-pill">
                                            {{ $listing->type_log }}
                                        </span>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body d-flex flex-column p-3">
                                        <!-- Header -->
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title mb-0 fw-bold text-dark">{{ $listing->ville }}</h6>
                                            <span class="fs-5 fw-bold text-primary">{{ number_format($listing->prix_log, 0, ',', '.') }} MAD</span>
                                        </div>

                                        <!-- Equipment/Amenities -->
                                        <div class="mb-3 flex-grow-1">
                                            @if($listing->equipements)
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach(array_slice(json_decode($listing->equipements, true), 0, 3) as $equipement)
                                                        <span class="badge bg-light text-dark border small">{{ $equipement }}</span>
                                                    @endforeach
                                                    @if(count(json_decode($listing->equipements, true)) > 3)
                                                        <span class="badge bg-light text-muted border small">+{{ count(json_decode($listing->equipements, true)) - 3 }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted small">Aucun équipement spécifié</span>
                                            @endif
                                        </div>

                                        <!-- Rating -->
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center gap-1">
                                                @for($i = 0; $i < 5; $i++)
                                                    <i class="fas fa-star text-warning small"></i>
                                                @endfor
                                                <span class="text-muted small ms-1">(4.8)</span>
                                            </div>
                                        </div>

                                        <!-- Action Button -->
                                        <a href="{{ route('proprietaire.details', $listing->id) }}" 
                                           class="btn btn-primary w-100 rounded-pill fw-medium">
                                            <i class="fas fa-eye me-2"></i>Voir détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="fas fa-search fa-3x text-muted"></i>
                                    </div>
                                    <h4 class="text-muted">Aucun logement trouvé</h4>
                                    <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                                    <button type="button" class="btn btn-outline-primary" onclick="document.querySelector('form').reset();">
                                        Réinitialiser les filtres
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if(ceil($total / $perPage) > 1)
                        <div class="d-flex justify-content-center mt-5">
                            <nav aria-label="Navigation des pages">
                                <ul class="pagination pagination-lg">
                                    @if($page > 1)
                                        <li class="page-item">
                                            <a class="page-link rounded-start-pill" 
                                               href="{{ route('proprietaire.logements', array_merge(request()->query(), ['page' => $page - 1])) }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif
                                    
                                    @for($i = max(1, $page - 2); $i <= min(ceil($total / $perPage), $page + 2); $i++)
                                        <li class="page-item {{ $i == $page ? 'active' : '' }}">
                                            <a class="page-link" 
                                               href="{{ route('proprietaire.logements', array_merge(request()->query(), ['page' => $i])) }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endfor
                                    
                                    @if($page < ceil($total / $perPage))
                                        <li class="page-item">
                                            <a class="page-link rounded-end-pill" 
                                               href="{{ route('proprietaire.logements', array_merge(request()->query(), ['page' => $page + 1])) }}">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --bs-primary: #244F76;
            --bs-primary-rgb: 36, 79, 118;
            --bs-secondary: #447892;
            --bs-light: #7C9FC0;
            --bs-cream: #EBDFD5;
        }

        /* Add these new styles for the filter sidebar */
        .filter-sidebar {
            top: 20px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--bs-primary) transparent;
        }

        .filter-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .filter-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .filter-sidebar::-webkit-scrollbar-thumb {
            background-color: var(--bs-primary);
            border-radius: 3px;
        }

        /* Ensure the main content doesn't get hidden behind the sticky sidebar */
        @media (min-width: 992px) {
            .col-lg-9 {
                position: relative;
                z-index: 1;
            }
        }

        .listing-card {
            transition: all 0.3s ease;
            border-radius: 15px !important;
        }

        .listing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(36, 79, 118, 0.15) !important;
        }

        .listing-card:hover img {
            transform: scale(1.05);
        }

        .hover-overlay {
            background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.3) 100%);
            transition: opacity 0.3s ease;
        }

        .listing-card:hover .hover-overlay {
            opacity: 1;
        }

        .favorite-btn {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .favorite-btn:hover {
            transform: scale(1.1);
            background-color: rgba(255, 255, 255, 0.9) !important;
        }

        .form-check-input:checked {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .btn-primary {
            background-color: var(--bs-primary) !important;
            border-color: var(--bs-primary) !important;
        }

        .btn-primary:hover {
            background-color: var(--bs-secondary) !important;
            border-color: var(--bs-secondary) !important;
        }

        .text-primary {
            color: var(--bs-primary) !important;
        }

        .bg-primary {
            background-color: var(--bs-primary) !important;
        }

        .border-primary {
            border-color: var(--bs-primary) !important;
        }

        .pagination .page-link {
            color: var(--bs-primary);
            border-color: #dee2e6;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .pagination .page-link:hover {
            background-color: rgba(36, 79, 118, 0.1);
            border-color: var(--bs-primary);
        }

        .bg-primary-subtle {
            background-color: rgba(36, 79, 118, 0.1) !important;
        }

        .card {
            border-radius: 15px;
        }

        .form-floating > .form-control-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .form-floating > .form-label-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
        }

        @media (max-width: 768px) {
            .listing-card:hover {
                transform: none;
            }
            
            .sticky-top {
                position: relative !important;
            }
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .bg-gradient-to-bottom {
            background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.3));
        }
    </style>

    <script>
        // Enhanced form interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit form on filter change (optional)
            const filterInputs = document.querySelectorAll('input[type="checkbox"], input[type="month"]');
            filterInputs.forEach(input => {
                input.addEventListener('change', function() {
                    // Optional: Auto-submit form when filters change
                    // this.form.submit();
                });
            });

            // Favorite button functionality
            const favoriteButtons = document.querySelectorAll('.favorite-btn');
            favoriteButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.classList.toggle('favorited');
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fas');
                    icon.classList.toggle('far');
                });
            });

            // Enhanced card hover effects
            const cards = document.querySelectorAll('.listing-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endsection