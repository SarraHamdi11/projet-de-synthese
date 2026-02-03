@extends('layouts.app')

@section('content')
<style>
/* Enhanced Professional Card Styles */
.professional-card {
    background: linear-gradient(135deg, var(--white) 0%, #f8f9fa 100%);
    border: none;
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-md);
    transition: all var(--transition);
    position: relative;
    overflow: hidden;
}

.professional-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.professional-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-light), var(--primary-dark));
}

/* Enhanced Card Annonce Styles */
.card-annonce {
    border: none;
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition);
    height: 100%;
    background: var(--white);
    position: relative;
}

.card-annonce::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-light), var(--primary-dark));
    opacity: 0;
    transition: opacity var(--transition);
}

.card-annonce:hover::before {
    opacity: 1;
}

.card-annonce:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: var(--shadow-xl);
}

.card-annonce .card-img-top {
    height: 220px;
    object-fit: cover;
    transition: transform var(--transition);
}

.card-annonce:hover .card-img-top {
    transform: scale(1.05);
}

.card-annonce .card-body {
    padding: var(--spacing-lg);
}

.card-annonce .card-title {
    color: var(--primary-dark);
    font-weight: 700;
    font-size: var(--font-lg);
    margin-bottom: var(--spacing-sm);
    transition: color var(--transition);
}

.card-annonce:hover .card-title {
    color: var(--primary-light);
}

.card-annonce .card-text {
    color: var(--text-light);
    line-height: var(--leading-relaxed);
    margin-bottom: var(--spacing-md);
}

/* Enhanced Button Styles */
.btn-primary-custom {
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
    border: none;
    border-radius: var(--radius-xl);
    font-weight: 600;
    padding: var(--spacing-md) var(--spacing-xl);
    font-size: var(--font-lg);
    transition: all var(--transition);
    color: var(--white);
    position: relative;
    overflow: hidden;
    text-transform: none;
    letter-spacing: 0.01em;
}

.btn-primary-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left var(--transition-slow);
}

.btn-primary-custom:hover::before {
    left: 100%;
}

.btn-primary-custom:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
}

.btn-primary-custom:active {
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

/* Enhanced Section Titles */
.section-title {
    color: var(--primary-dark);
    font-weight: 700;
    margin-bottom: var(--spacing-lg);
    position: relative;
    text-align: center;
    font-size: var(--font-3xl);
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -var(--spacing-sm);
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-light), var(--primary-dark));
    border-radius: var(--radius-sm);
}

/* Enhanced Form Controls */
.form-control, .form-select {
    border: 2px solid var(--primary-lighter);
    border-radius: var(--radius-lg);
    padding: var(--spacing-sm) var(--spacing-md);
    transition: all var(--transition);
    font-size: var(--font-base);
    background: var(--white);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-light);
    box-shadow: 0 0 0 0.2rem rgba(124, 159, 192, 0.25);
    outline: none;
    transform: translateY(-1px);
}

.form-control:hover, .form-select:hover {
    border-color: var(--primary-light);
}

/* Enhanced Dropdown */
.dropdown-menu {
    border: none;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    padding: var(--spacing-sm);
    background: var(--white);
    animation: dropdownFadeIn var(--transition);
    margin-top: var(--spacing-xs);
}

.dropdown-item {
    border-radius: var(--radius-md);
    padding: var(--spacing-sm) var(--spacing-md);
    transition: all var(--transition);
    margin-bottom: var(--spacing-xs);
}

.dropdown-item:hover {
    background: var(--primary-lighter);
    color: var(--primary-dark);
    transform: translateX(4px);
}

/* Enhanced Empty State */
.empty-state {
    text-align: center;
    padding: var(--spacing-2xl);
    color: var(--text-light);
}

.empty-state i {
    font-size: 4rem;
    color: var(--primary-lighter);
    margin-bottom: var(--spacing-lg);
    opacity: 0.6;
}

.empty-state h5 {
    color: var(--text-dark);
    font-weight: 600;
    margin-bottom: var(--spacing-sm);
}

.empty-state p {
    color: var(--text-light);
    font-size: var(--font-lg);
}

/* Enhanced Badge Styles */
.badge {
    font-weight: 600;
    font-size: var(--font-xs);
    padding: var(--spacing-xs) var(--spacing-sm);
    border-radius: var(--radius-full);
    letter-spacing: 0.025em;
}

.badge.bg-success {
    background: linear-gradient(135deg, var(--success) 0%, #20c997 100%) !important;
}

.badge.bg-secondary {
    background: linear-gradient(135deg, var(--text-light) 0%, #6c757d 100%) !important;
}

/* Enhanced Animations */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes dropdownFadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-in {
    animation: slideInUp 0.6s ease forwards;
}

/* Responsive Enhancements */
@media (max-width: 768px) {
    .section-title {
        font-size: var(--font-2xl);
    }
    
    .btn-primary-custom {
        padding: var(--spacing-sm) var(--spacing-lg);
        font-size: var(--font-base);
    }
    
    .professional-card {
        margin-bottom: var(--spacing-md);
    }
    
    .card-annonce {
        margin-bottom: var(--spacing-md);
    }
}

/* Enhanced Focus States */
*:focus {
    outline: none;
}

*:focus-visible {
    outline: 2px solid var(--primary-light);
    outline-offset: 2px;
}

/* Enhanced Hover States */
.hover-lift {
    transition: all var(--transition);
}

.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

/* Enhanced Loading States */
.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-xl);
    z-index: 10;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid var(--primary-lighter);
    border-top: 4px solid var(--primary-light);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<div class="container mx-auto px-4 py-5">
    {{-- Enhanced Messages de succès et d'erreur --}}
    @if(session('success'))
    <div class="alert alert-success alert-custom d-flex align-items-center" role="alert">
        <svg class="me-3" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <div>
            <strong>Succès!</strong> {{ session('success') }}
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Enhanced Formulaire de création --}}
    <div class="text-center mb-5">
        <h2 class="section-title animate-in">
            <i class="fas fa-bullhorn me-2"></i>
            Mes Annonces
        </h2>
        <p class="text-muted mt-3 animate-in" style="font-size: var(--font-lg);">Gérez vos annonces de logement</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="professional-card p-4 p-md-5 animate-in">
                <div class="text-center mb-4">
                    <button type="button" class="btn btn-primary-custom btn-lg hover-lift" data-bs-toggle="modal" data-bs-target="#createAnnonceModal">
                        <i class="fas fa-plus-circle me-2"></i>
                        Créer une nouvelle annonce
                    </button>
                </div>

                <!-- Enhanced Create Annonce Modal -->
                <div class="modal fade" id="createAnnonceModal" tabindex="-1" aria-labelledby="createAnnonceModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createAnnonceModalLabel">
                                    <i class="fas fa-plus-circle me-2"></i>Créer une annonce
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('proprietaire.annonces.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="logement_id" class="form-label">
                                                <i class="fas fa-home me-2"></i>Sélectionner un logement
                                            </label>
                                            @php
                                                $logements = \App\Models\Logement::where('proprietaire_id', auth()->user()->id)->get();
                                            @endphp
                                            <select name="logement_id" id="logement_id" class="form-select" required>
                                                <option value="">Choisir un logement...</option>
                                                @forelse($logements as $logement)
                                                    <option value="{{ $logement->id }}">
                                                        <i class="fas fa-home me-1"></i> {{ $logement->titre_log ?? 'Logement #' . $logement->id }} - {{ $logement->prix_log ?? 0 }} DH/mois
                                                    </option>
                                                @empty
                                                    <option value="" disabled>Aucun logement disponible</option>
                                                @endforelse
                                            </select>
                                            @error('logement_id')
                                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="titre_anno" class="form-label">
                                                <i class="fas fa-heading me-2"></i>Titre de l'annonce
                                            </label>
                                            <input type="text" name="titre_anno" id="titre_anno" class="form-control" 
                                                   value="{{ old('titre_anno') }}" required placeholder="Ex: Appartement moderne centre-ville">
                                            @error('titre_anno')
                                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="description_anno" class="form-label">
                                                <i class="fas fa-align-left me-2"></i>Description détaillée
                                            </label>
                                            <textarea name="description_anno" id="description_anno" rows="5" class="form-control" 
                                                      required placeholder="Décrivez votre logement, les commodités...">{{ old('description_anno') }}</textarea>
                                            @error('description_anno')
                                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="disponibilite_annonce" class="form-label">
                                                <i class="fas fa-calendar-check me-2"></i>Disponibilité
                                            </label>
                                            <select name="disponibilite_annonce" id="disponibilite_annonce" class="form-select" required>
                                                <option value="">Sélectionner...</option>
                                                <option value="1" {{ old('disponibilite_annonce', 1) == 1 ? 'selected' : '' }}>Disponible immédiatement</option>
                                                <option value="0" {{ old('disponibilite_annonce') == 0 ? 'selected' : '' }}>Non disponible</option>
                                            </select>
                                            @error('disponibilite_annonce')
                                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="photos_annonce" class="form-label">
                                                <i class="fas fa-camera me-2"></i>Photos du logement
                                            </label>
                                            <input type="file" name="photos[]" id="photos_annonce" multiple 
                                                   accept="image/jpeg,image/png,image/jpg" class="form-control">
                                            <small class="text-muted mt-1">Formats acceptés: JPG, PNG. Plusieurs photos possibles.</small>
                                            @error('photos.*')
                                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                                            @enderror
                                            @error('photos')
                                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="fas fa-paper-plane me-2"></i>Publier l'annonce
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Liste des annonces --}}
    <div class="text-center mb-5">
        <h2 class="section-title animate-in">
            <i class="fas fa-list me-2"></i>
            Vos Annonces Publiées
        </h2>
        <p class="text-muted mt-3 animate-in" style="font-size: var(--font-lg);">Consultez et gérez vos annonces actives</p>
    </div>

    <div class="row g-4" id="annoncesList">
        @forelse($annonces as $annonce)
            <div class="col-lg-4 col-md-6 animate-in">
                <div class="card-annonce">
                    @if($annonce->logement && $annonce->logement->photos)
                        @php $photos = is_array($annonce->logement->photos) ? $annonce->logement->photos : json_decode($annonce->logement->photos, true); @endphp
                        @if(is_array($photos) && count($photos) > 0)
                            <img src="{{ asset($photos[0]) }}" class="card-img-top" alt="Photo" style="height: 220px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Photo" style="height: 220px; object-fit: cover;">
                        @endif
                    @else
                        <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Photo" style="height: 220px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $annonce->titre_anno }}</h5>
                        <p class="card-text">{{ Str::limit($annonce->description_anno, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge {{ $annonce->disponibilite_annonce ? 'bg-success' : 'bg-secondary' }}">
                                {{ $annonce->disponibilite_annonce ? 'Disponible' : 'Non disponible' }}
                            </span>
                            <small class="text-muted">{{ $annonce->created_at->format('d/m/Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 empty-state animate-in">
                <i class="fas fa-bullhorn fa-3x mb-3"></i>
                <h5>Aucune annonce pour le moment</h5>
                <p>Utilisez le formulaire ci-dessus pour créer votre première annonce</p>
            </div>
        @endforelse
    </div>
</div>
@endsection