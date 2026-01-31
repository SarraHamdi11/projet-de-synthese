@extends('layouts.app')

@section('content')
{{-- Polices personnalisées --}}
<link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }
    
    .title-font {
        font-family: 'Inknut Antiqua', serif;
    }
    
    .professional-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(36, 79, 118, 0.08);
        border: 1px solid rgba(36, 79, 118, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .professional-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(36, 79, 118, 0.15);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #447892;
        box-shadow: 0 0 0 0.2rem rgba(68, 120, 146, 0.25);
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #447892 0%, #244F76 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(68, 120, 146, 0.3);
    }
    
    .btn-secondary-custom {
        background: #EBDFD5;
        color: #244F76;
        border: 1px solid rgba(36, 79, 118, 0.2);
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-secondary-custom:hover {
        background: #244F76;
        color: white;
        transform: translateY(-1px);
    }
    
    .alert-custom {
        border-radius: 15px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .form-label {
        font-weight: 600;
        color: #244F76;
        margin-bottom: 8px;
    }
    
    .form-control, .form-select {
        border: 2px solid rgba(36, 79, 118, 0.2);
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .form-control:hover, .form-select:hover {
        border-color: #7C9FC0;
    }
    
    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 40px;
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

    {{-- Formulaire de modification avec design professionnel --}}
    <div class="text-center mb-5">
        <h2 class="title-font section-title" style="color:#244F76; font-weight:700; font-size:2.5rem;">
            Modifier l'annonce
        </h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Mettez à jour votre annonce de colocation</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="professional-card p-4 p-md-5">
                <form id="form-edit-annonce" method="POST" action="{{ route('locataire.annoncelocataire.update', $annonce->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="titre_anno" class="form-label">
                                <i class="fas fa-heading me-2"></i>Titre de l'annonce
                            </label>
                            <input type="text" name="titre_anno" id="titre_anno" class="form-control" 
                                   value="{{ old('titre_anno', $annonce->titre_anno) }}" required placeholder="Ex: Colocation sympa centre-ville">
                            @error('titre_anno')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="type_log" class="form-label">
                                <i class="fas fa-home me-2"></i>Type de logement
                            </label>
                            <select name="type_log" id="type_log" class="form-select" required>
                                <option value="">Choisissez le type</option>
                                <option value="studio" {{ old('type_log', $annonce->logement->type_log) == 'studio' ? 'selected' : '' }}>Studio</option>
                                <option value="appartement" {{ old('type_log', $annonce->logement->type_log) == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                <option value="maison" {{ old('type_log', $annonce->logement->type_log) == 'maison' ? 'selected' : '' }}>Maison</option>
                            </select>
                            @error('type_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="prix_log" class="form-label">
                                <i class="fas fa-coins me-2"></i>Budget mensuel (MAD)
                            </label>
                            <input type="number" name="prix_log" id="prix_log" class="form-control" 
                                   value="{{ old('prix_log', $annonce->logement->prix_log) }}" required placeholder="Ex: 3000">
                            @error('prix_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="ville" class="form-label">
                                <i class="fas fa-city me-2"></i>Ville
                            </label>
                            <select name="ville" id="ville" class="form-select" required>
                                <option value="">Sélectionnez une ville</option>
                                <option value="Tétouan" {{ old('ville', $annonce->logement->ville ?? '') == 'Tétouan' ? 'selected' : '' }}>Tétouan</option>
                                <option value="Tanger" {{ old('ville', $annonce->logement->ville ?? '') == 'Tanger' ? 'selected' : '' }}>Tanger</option>
                                <option value="Martil" {{ old('ville', $annonce->logement->ville ?? '') == 'Martil' ? 'selected' : '' }}>Martil</option>
                                <option value="Rincon" {{ old('ville', $annonce->logement->ville ?? '') == 'Rincon' ? 'selected' : '' }}>Rincon</option>
                                <option value="Hoceima" {{ old('ville', $annonce->logement->ville ?? '') == 'Hoceima' ? 'selected' : '' }}>Hoceima</option>
                                <option value="Chaouen" {{ old('ville', $annonce->logement->ville ?? '') == 'Chaouen' ? 'selected' : '' }}>Chaouen</option>
                            </select>
                            @error('ville')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nombre_colocataire_log" class="form-label">
                                <i class="fas fa-users me-2"></i>Nombre de colocataires
                            </label>
                            <input type="number" name="nombre_colocataire_log" id="nombre_colocataire_log" class="form-control" 
                                   value="{{ old('nombre_colocataire_log', $annonce->logement->nombre_colocataire_log) }}" required placeholder="Ex: 2">
                            @error('nombre_colocataire_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="localisation_log" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Localisation précise
                            </label>
                            <input type="text" name="localisation_log" id="localisation_log" class="form-control" 
                                   value="{{ old('localisation_log', $annonce->logement->localisation_log) }}" required placeholder="Ex: Quartier Hassan">
                            @error('localisation_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="photos_locataire" class="form-label">
                                <i class="fas fa-camera me-2"></i>Photos du logement
                            </label>
                            <input type="file" name="photos[]" id="photos_locataire" multiple 
                                   accept="image/jpeg,image/png,image/jpg" class="form-control">
                            <small class="text-muted mt-1">Formats acceptés: JPG, PNG. Plusieurs photos possibles.</small>
                            @error('photos.*')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                            @error('photos')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                            @if($annonce->logement->photos)
                                <div id="existing-photos-locataire" class="mt-2 d-flex flex-wrap gap-2">
                                    @foreach(json_decode($annonce->logement->photos, true) as $photo)
                                        <div class="position-relative">
                                            <img src="{{ asset($photo) }}" width="100" height="100" class="img-thumbnail" style="object-fit: cover;" data-photo-url="{{ $photo }}">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 translate-middle rounded-circle delete-photo-locataire" style="width: 24px; height: 24px; padding: 0; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="col-12">
                            <label for="description_anno" class="form-label">
                                <i class="fas fa-align-left me-2"></i>Description détaillée
                            </label>
                            <textarea name="description_anno" id="description_anno" rows="5" class="form-control" 
                                      required placeholder="Décrivez votre logement, les commodités, l'ambiance recherchée...">{{ old('description_anno', $annonce->description_anno) }}</textarea>
                            @error('description_anno')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Mettre à jour l'annonce
                        </button>
                        <a href="{{ route('locataire.annonceslocataire.index') }}" class="btn btn-secondary-custom btn-lg ms-3">
                            <i class="fas fa-times me-2"></i>Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const existingPhotosContainerLocataire = document.getElementById('existing-photos-locataire');

        if (existingPhotosContainerLocataire) {
            existingPhotosContainerLocataire.addEventListener('click', function (e) {
                if (e.target.closest('.delete-photo-locataire')) {
                    const button = e.target.closest('.delete-photo-locataire');
                    const photoDiv = button.closest('.position-relative');
                    const photoUrl = photoDiv.querySelector('img').dataset.photoUrl;

                    if (confirm('Are you sure you want to delete this photo?')) {
                        photoDiv.remove();

                        const form = document.getElementById('form-edit-annonce');
                        const deletedPhotoInput = document.createElement('input');
                        deletedPhotoInput.type = 'hidden';
                        deletedPhotoInput.name = 'deleted_photos[]'; // Use same input name as owner form
                        deletedPhotoInput.value = photoUrl;
                        form.appendChild(deletedPhotoInput);
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection