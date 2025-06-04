@extends('layouts.app')

@section('content')

{{-- Polices personnalisées --}}
<link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --bleu-fonce: #244F76;
        --bleu-moyen: #447892;
        --bleu-clair: #7C9FC0;
        --creme: #EBDFD5;
        --blanc: #fff;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .title-font {
        font-family: 'Inknut Antiqua', serif;
    }

    .professional-card {
        background: var(--blanc);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(36, 79, 118, 0.08);
        border: 1px solid rgba(36, 79, 118, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .professional-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(36, 79, 118, 0.15);
    }

    .form-label {
        font-weight: 600;
        color: var(--bleu-fonce);
        margin-bottom: 8px;
    }

    .form-control, .form-select, .form-check-input {
        border: 2px solid rgba(36, 79, 118, 0.2);
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--bleu-moyen);
        box-shadow: 0 0 0 0.2rem rgba(68, 120, 146, 0.25);
    }

    .form-control:hover, .form-select:hover, .form-check-input:hover {
        border-color: var(--bleu-clair);
    }

    .form-check-input {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0.25em;
    }

    .form-check-label {
        color: var(--bleu-fonce);
        font-size: 14px;
        margin-left: 8px;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        color: var(--blanc);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(68, 120, 146, 0.3);
    }

    .btn-secondary-custom {
        background: var(--creme);
        color: var(--bleu-fonce);
        border: 1px solid rgba(36, 79, 118, 0.2);
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background: var(--bleu-fonce);
        color: var(--blanc);
        transform: translateY(-1px);
    }

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 40px;
        color: var(--bleu-fonce);
        font-family: 'Inknut Antiqua', serif;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, var(--bleu-moyen) 0%, var(--bleu-fonce) 100%);
        border-radius: 2px;
    }

    .alert-custom {
        border-radius: 15px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
</style>

<div class="container mx-auto px-4 py-5">
    <div class="text-center mb-5">
        <h2 class="title-font section-title" style="font-weight: 700; font-size: 2.5rem;">
            Modifier une annonce
        </h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Mettez à jour les détails de votre annonce de colocation</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="professional-card p-4 p-md-5">
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

                <form action="{{ route('proprietaire.annoncesproprietaire.update', $annonce->id) }}" method="POST" enctype="multipart/form-data" id="form-annonce-proprietaire">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Photos --}}
                        <div class="col-12">
                            <label for="photos_proprietaire" class="form-label">
                                <i class="fas fa-camera me-2"></i>Photos du logement
                            </label>
                            <input type="file" name="photos[]" id="photos_proprietaire" multiple accept="image/jpeg,image/png,image/jpg" class="form-control">
                            <small class="text-muted mt-1">Formats acceptés: JPG, PNG. Plusieurs photos possibles.</small>
                            @error('photos.*')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                            @error('photos')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                            @if($annonce->logement->photos)
                                <div id="existing-photos" class="mt-2 d-flex flex-wrap gap-2">
                                    @foreach(json_decode($annonce->logement->photos, true) as $photo)
                                        <div class="position-relative">
                                            <img src="{{ asset($photo) }}" width="100" height="100" class="img-thumbnail" style="object-fit: cover;" data-photo-url="{{ $photo }}">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 translate-middle rounded-circle delete-photo" style="width: 24px; height: 24px; padding: 0; display: flex; justify-content: center; align-items: center;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Titre --}}
                        <div class="col-md-6">
                            <label for="titre_anno_proprietaire" class="form-label">
                                <i class="fas fa-heading me-2"></i>Titre de l'annonce
                            </label>
                            <input type="text" name="titre_anno" id="titre_anno_proprietaire" class="form-control" value="{{ old('titre_anno', $annonce->titre_anno) }}" required placeholder="Ex: Colocation sympa centre-ville">
                            @error('titre_anno')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        {{-- Prix --}}
                        <div class="col-md-6">
                            <label for="prix_log_proprietaire" class="form-label">
                                <i class="fas fa-coins me-2"></i>Prix mensuel (MAD)
                            </label>
                            <input type="number" name="prix_log" id="prix_log_proprietaire" class="form-control" value="{{ old('prix_log', $annonce->logement->prix_log) }}" required placeholder="Ex: 3000">
                            @error('prix_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        {{-- Localisation --}}
                        <div class="col-md-6">
                            <label for="localisation_log_proprietaire" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Localisation précise
                            </label>
                            <input type="text" name="localisation_log" id="localisation_log_proprietaire" class="form-control" value="{{ old('localisation_log', $annonce->logement->localisation_log) }}" required placeholder="Ex: Quartier Hassan">
                            @error('localisation_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        {{-- Type de logement --}}
                        <div class="col-md-6">
                            <label for="type_log_proprietaire" class="form-label">
                                <i class="fas fa-home me-2"></i>Type de logement
                            </label>
                            <select name="type_log" id="type_log_proprietaire" class="form-select" required>
                                <option value="">Choisissez le type</option>
                                <option value="appartement" {{ old('type_log', $annonce->logement->type_log ?? '') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                <option value="studio" {{ old('type_log', $annonce->logement->type_log ?? '') == 'studio' ? 'selected' : '' }}>Studio</option>
                                <option value="maison" {{ old('type_log', $annonce->logement->type_log ?? '') == 'maison' ? 'selected' : '' }}>Maison</option>
                            </select>
                            @error('type_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        {{-- Ville --}}
                        <div class="col-md-6">
                            <label for="ville_proprietaire" class="form-label">
                                <i class="fas fa-city me-2"></i>Ville
                            </label>
                            <select name="ville" id="ville_proprietaire" class="form-select" required>
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

                        {{-- Nombre de colocataires --}}
                        <div class="col-md-6">
                            <label for="nombre_colocataire_log_proprietaire" class="form-label">
                                <i class="fas fa-users me-2"></i>Nombre de colocataires
                            </label>
                            <input type="number" name="nombre_colocataire_log" id="nombre_colocataire_log_proprietaire" class="form-control" value="{{ old('nombre_colocataire_log', $annonce->logement->nombre_colocataire_log ?? 1) }}" min="1" required placeholder="Ex: 2">
                            @error('nombre_colocataire_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        {{-- Étage --}}
                        <div class="col-md-6">
                            <label for="etage_proprietaire" class="form-label">
                                <i class="fas fa-building me-2"></i>Étage (optionnel)
                            </label>
                            <input type="number" name="etage" id="etage_proprietaire" class="form-control" value="{{ old('etage', $annonce->logement->etage ?? '') }}" min="0" placeholder="Ex: 3">
                            @error('etage')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        {{-- Équipements --}}
                        <div class="col-12">
                            <label class="form-label">
                                <i class="fas fa-tools me-2"></i>Équipements
                            </label>
                            <div class="row g-4">
                                @foreach(['Wi-Fi', 'Climatisation/Chauffage', 'Télévision', 'Machine à laver', 'Cuisine équipée', 'Réfrigérateur', 'Douche/Baignoire', 'Parking', 'Draps et serviettes fournies', 'Balcon/Terrasse'] as $equipement)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="equipements[]" value="{{ $equipement }}" class="form-check-input" {{ in_array($equipement, old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $equipement }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @error('equipements')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-save me-2"></i>Mettre à jour l'annonce
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const existingPhotosContainer = document.getElementById('existing-photos');

        if (existingPhotosContainer) {
            existingPhotosContainer.addEventListener('click', function (e) {
                if (e.target.closest('.delete-photo')) {
                    const button = e.target.closest('.delete-photo');
                    const photoDiv = button.closest('.position-relative');
                    const photoUrl = photoDiv.querySelector('img').dataset.photoUrl;

                    if (confirm('Are you sure you want to delete this photo?')) {
                        // For now, just visually remove the photo and prepare for controller handling
                        photoDiv.remove();

                        // We will need to handle the actual deletion in the controller
                        // when the form is submitted, or via a separate AJAX call.
                        // For submission with the form, we could add a hidden input.
                        // Let's add a hidden input to the form for deleted photos.
                        const form = document.getElementById('form-annonce-proprietaire');
                        const deletedPhotoInput = document.createElement('input');
                        deletedPhotoInput.type = 'hidden';
                        deletedPhotoInput.name = 'deleted_photos[]';
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