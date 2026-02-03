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
</style>

<div class="container mx-auto px-4 py-5">
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

    <div class="text-center mb-5">
        <h2 class="title-font section-title" style="color:#244F76; font-weight:700; font-size:2.5rem;">
            Créer un logement
        </h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Ajoutez votre logement pour pouvoir créer des annonces</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="professional-card p-4 p-md-5">
                <form method="POST" action="{{ route('locataire.logements.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="titre_log" class="form-label">
                                <i class="fas fa-heading me-2"></i>Titre du logement
                            </label>
                            <input type="text" name="titre_log" id="titre_log" class="form-control" 
                                   value="{{ old('titre_log') }}" required placeholder="Ex: Appartement moderne centre-ville">
                            @error('titre_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="type_log" class="form-label">
                                <i class="fas fa-home me-2"></i>Type de logement
                            </label>
                            <select name="type_log" id="type_log" class="form-select" required>
                                <option value="">Choisir le type</option>
                                <option value="studio" {{ old('type_log') == 'studio' ? 'selected' : '' }}>Studio</option>
                                <option value="appartement" {{ old('type_log') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                <option value="maison" {{ old('type_log') == 'maison' ? 'selected' : '' }}>Maison</option>
                            </select>
                            @error('type_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="prix_log" class="form-label">
                                <i class="fas fa-coins me-2"></i>Prix mensuel (DH)
                            </label>
                            <input type="number" name="prix_log" id="prix_log" class="form-control" 
                                   value="{{ old('prix_log') }}" required placeholder="Ex: 3000">
                            @error('prix_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nombre_colocataire_log" class="form-label">
                                <i class="fas fa-users me-2"></i>Nombre de colocataires
                            </label>
                            <input type="number" name="nombre_colocataire_log" id="nombre_colocataire_log" class="form-control" 
                                   value="{{ old('nombre_colocataire_log') }}" required placeholder="Ex: 2">
                            @error('nombre_colocataire_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="ville" class="form-label">
                                <i class="fas fa-city me-2"></i>Ville
                            </label>
                            <select name="ville" id="ville" class="form-select" required>
                                <option value="">Sélectionner une ville</option>
                                <option value="Tétouan" {{ old('ville') == 'Tétouan' ? 'selected' : '' }}>Tétouan</option>
                                <option value="Tanger" {{ old('ville') == 'Tanger' ? 'selected' : '' }}>Tanger</option>
                                <option value="Martil" {{ old('ville') == 'Martil' ? 'selected' : '' }}>Martil</option>
                                <option value="Rincon" {{ old('ville') == 'Rincon' ? 'selected' : '' }}>Rincon</option>
                                <option value="Hoceima" {{ old('ville') == 'Hoceima' ? 'selected' : '' }}>Hoceima</option>
                                <option value="Chaouen" {{ old('ville') == 'Chaouen' ? 'selected' : '' }}>Chaouen</option>
                            </select>
                            @error('ville')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="localisation_log" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Localisation précise
                            </label>
                            <input type="text" name="localisation_log" id="localisation_log" class="form-control" 
                                   value="{{ old('localisation_log') }}" required placeholder="Ex: Quartier Hassan">
                            @error('localisation_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description_log" class="form-label">
                                <i class="fas fa-align-left me-2"></i>Description détaillée
                            </label>
                            <textarea name="description_log" id="description_log" rows="5" class="form-control" 
                                      required placeholder="Décrivez votre logement en détail...">{{ old('description_log') }}</textarea>
                            @error('description_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="photos" class="form-label">
                                <i class="fas fa-camera me-2"></i>Photos du logement
                            </label>
                            <input type="file" name="photos[]" id="photos" multiple 
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

                    <div class="text-center mt-4">
                        <a href="{{ route('locataire.annonces.index') }}" class="btn btn-secondary me-3">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-save me-2"></i>Créer le logement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
