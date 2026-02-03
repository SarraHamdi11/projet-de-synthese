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

.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #7C9FC0 0%, #24507a 100%);
    border: none;
    border-radius: 10px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.section-title {
    color: #24507a;
    font-weight: 700;
    margin-bottom: 1rem;
}
</style>

<div class="container mx-auto px-4 py-5">
    @if(session('success'))
    <div class="alert alert-success alert-custom d-flex align-items-center" role="alert">
        <strong>Succès!</strong> {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="text-center mb-5">
        <h2 class="section-title" style="font-size:2.5rem;">Créer une annonce premium</h2>
        <p class="text-muted mt-3">Publiez votre annonce de logement en quelques clics</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="professional-card p-4 p-md-5">
                <form method="POST" action="{{ route('proprietaire.annonces.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="logement_id" value="{{ $logement->id }}">
                    
                    <div class="mb-4">
                        <h4 class="section-title"><i class="fas fa-home me-2"></i>Logement sélectionné</h4>
                        <div class="alert alert-info">
                            <strong>{{ $logement->titre_log ?? 'Logement #' . $logement->id }}</strong><br>
                            <small>{{ $logement->type_log ?? 'Non spécifié' }} | 
                            {{ $logement->localisation_log ?? 'Non spécifié' }} | 
                            {{ $logement->prix_log ?? 0 }} DH/mois</small>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-heading me-2"></i>Titre de l'annonce *</label>
                            <input type="text" name="titre_anno" class="form-control" value="{{ old('titre_anno') }}" required placeholder="Ex: Appartement moderne centre-ville">
                            @error('titre_anno')<div class="text-danger mt-2"><small>{{ $message }}</small></div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-calendar-check me-2"></i>Disponibilité *</label>
                            <select name="disponibilite_annonce" class="form-select" required>
                                <option value="">Sélectionnez</option>
                                <option value="1" {{ old('disponibilite_annonce', 1) == 1 ? 'selected' : '' }}>Disponible immédiatement</option>
                                <option value="0" {{ old('disponibilite_annonce') == 0 ? 'selected' : '' }}>Non disponible</option>
                            </select>
                            @error('disponibilite_annonce')<div class="text-danger mt-2"><small>{{ $message }}</small></div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label"><i class="fas fa-align-left me-2"></i>Description détaillée *</label>
                            <textarea name="description_anno" rows="6" class="form-control" required placeholder="Décrivez votre logement...">{{ old('description_anno') }}</textarea>
                            @error('description_anno')<div class="text-danger mt-2"><small>{{ $message }}</small></div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label"><i class="fas fa-camera me-2"></i>Photos</label>
                            <input type="file" name="photos[]" multiple accept="image/jpeg,image/png,image/jpg" class="form-control">
                            <small class="text-muted">Formats: JPG, PNG. Plusieurs photos possibles.</small>
                            @error('photos.*')<div class="text-danger mt-2"><small>{{ $message }}</small></div>@enderror
                        </div>

                        <div class="col-12">
                            <h5 class="section-title"><i class="fas fa-star me-2"></i>Options</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="options[]" value="wifi" id="wifi" class="form-check-input">
                                        <label for="wifi" class="form-check-label"><i class="fas fa-wifi me-1"></i> WiFi</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="options[]" value="parking" id="parking" class="form-check-input">
                                        <label for="parking" class="form-check-label"><i class="fas fa-car me-1"></i> Parking</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="options[]" value="climatisation" id="climatisation" class="form-check-input">
                                        <label for="climatisation" class="form-check-label"><i class="fas fa-snowflake me-1"></i> Climatisation</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="options[]" value="meuble" id="meuble" class="form-check-input">
                                        <label for="meuble" class="form-check-label"><i class="fas fa-couch me-1"></i> Meublé</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-4">
                            <a href="{{ route('proprietaire.annoncesproprietaire.index') }}" class="btn btn-secondary me-3">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer l'annonce
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
