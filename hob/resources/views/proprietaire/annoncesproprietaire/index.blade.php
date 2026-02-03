@extends('layouts.app')

@section('content')
<style>
.professional-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.professional-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}

.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #7C9FC0;
    box-shadow: 0 0 0 0.2rem rgba(124, 159, 192, 0.25);
}

.btn-primary-custom {
    background: linear-gradient(135deg, #7C9FC0 0%, #24507a 100%);
    border: none;
    border-radius: 20px;
    font-weight: 600;
    padding: 15px 40px;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    color: white;
}

.btn-primary-custom:hover {
    background: linear-gradient(135deg, #24507a 0%, #7C9FC0 100%);
    transform: translateY(-2px);
    color: white;
}

.alert-custom {
    border-radius: 15px;
    border: none;
    padding: 15px 20px;
}

.section-title {
    color: #24507a;
    font-weight: 700;
    margin-bottom: 1rem;
    position: relative;
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

.card-annonce {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.card-annonce:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.modal-header {
    background: linear-gradient(135deg, #7C9FC0 0%, #24507a 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    border: none;
}

.modal-body {
    padding: 2rem;
}
</style>

<div class="container mx-auto px-4 py-5">
    {{-- Messages de succès et d'erreur avec style amélioré --}}
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

    @if(session('error'))
    <div class="alert alert-danger alert-custom d-flex align-items-center" role="alert">
        <svg class="me-3" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <strong>Erreur!</strong> {{ session('error') }}
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Formulaire de création avec design professionnel --}}
    <div class="text-center mb-5">
        <h2 class="title-font section-title" style="color:#244F76; font-weight:700; font-size:2.5rem;">
            Mes Annonces
        </h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Gérez vos annonces de logement</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="professional-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <button type="button" class="btn btn-primary-custom btn-lg" data-bs-toggle="modal" data-bs-target="#createAnnonceModal">
                        <i class="fas fa-plus-circle me-2"></i>Créer une nouvelle annonce
                    </button>
                </div>

                <!-- Create Annonce Modal -->
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
                                                        {{ $logement->titre_log ?? 'Logement #' . $logement->id }} - {{ $logement->prix_log ?? 0 }} DH/mois
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

    {{-- Liste des annonces avec design amélioré --}}
    <div class="text-center mb-5">
        <h2 class="title-font section-title" style="color: #244F76; font-size: 2.2rem; font-weight: 700;">
            Vos Annonces Publiées
        </h2>
        <p class="text-muted mt-3">Consultez et gérez vos annonces actives</p>
    </div>

    <div class="row g-4" id="annoncesList">
        @forelse($annonces as $annonce)
            <div class="col-lg-4 col-md-6">
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
            <div class="col-12 text-center py-5">
                <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune annonce pour le moment</h5>
                <p class="text-muted">Cliquez sur "Créer une nouvelle annonce" pour commencer</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    .carousel-item img {
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }
    .carousel-control-prev,
    .carousel-control-next {
        width: 10%;
        opacity: 0.8;
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        padding: 1rem;
    }
</style>
@endpush
@endsection 