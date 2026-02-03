@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Créer une annonce pour {{ $logement->titre_log ?? 'Logement #' . $logement->id }}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('proprietaire.annonces.store') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="logement_id" value="{{ $logement->id }}">

                        <div class="mb-4">
                            <label for="titre_annonce" class="form-label fw-bold">Titre de l'annonce *</label>
                            <input type="text" 
                                   class="form-control @error('titre_annonce') is-invalid @enderror" 
                                   id="titre_annonce" 
                                   name="titre_annonce" 
                                   value="{{ old('titre_annonce') }}"
                                   placeholder="Entrez un titre attractif pour votre annonce"
                                   required>
                            @error('titre_annonce')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description_annonce" class="form-label fw-bold">Description de l'annonce *</label>
                            <textarea class="form-control @error('description_annonce') is-invalid @enderror" 
                                      id="description_annonce" 
                                      name="description_annonce" 
                                      rows="6" 
                                      placeholder="Décrivez votre logement en détail..."
                                      required>{{ old('description_annonce') }}</textarea>
                            @error('description_annonce')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Disponibilité *</label>
                            <div class="form-check">
                                <input class="form-check-input @error('disponibilite') is-invalid @enderror" 
                                       type="radio" 
                                       name="disponibilite" 
                                       id="disponibilite_true" 
                                       value="1" 
                                       {{ old('disponibilite', 1) == 1 ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label" for="disponibilite_true">
                                    <i class="fas fa-check-circle text-success me-1"></i>
                                    Disponible immédiatement
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('disponibilite') is-invalid @enderror" 
                                       type="radio" 
                                       name="disponibilite" 
                                       id="disponibilite_false" 
                                       value="0" 
                                       {{ old('disponibilite') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="disponibilite_false">
                                    <i class="fas fa-clock text-warning me-1"></i>
                                    Non disponible
                                </label>
                            </div>
                            @error('disponibilite')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Logement Information Summary -->
                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>
                                Informations du logement
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Type:</strong> {{ $logement->type_log ?? 'Non spécifié' }}</p>
                                    <p class="mb-1"><strong>Localisation:</strong> {{ $logement->localisation_log ?? 'Non spécifié' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Prix:</strong> {{ $logement->prix_log ?? 0 }} DH / mois</p>
                                    <p class="mb-1"><strong>Surface:</strong> {{ $logement->surface_log ?? 'Non spécifié' }} m²</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('proprietaire.annoncesproprietaire.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour aux annonces
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Créer l'annonce
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
