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
    .title-font { font-family: 'Inknut Antiqua', serif; }
    .form-label { font-weight: 600; color: #244F76; margin-bottom: 8px; }
    .form-control, .form-select {
        border: 2px solid rgba(36, 79, 118, 0.2);
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #447892;
        box-shadow: 0 0 0 0.2rem rgba(68, 120, 146, 0.25);
    }
    .form-control:hover, .form-select:hover { border-color: #7C9FC0; }
    .card-annonce, .card, .bg-white, .bg-creme {
        background: #EBDFD5;
        border-radius: 20px;
        border: 2px solid rgba(36, 79, 118, 0.1);
        box-shadow: 0 10px 40px rgba(36, 79, 118, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-annonce:hover, .card:hover {
        border-color: #7C9FC0;
        box-shadow: 0 20px 60px rgba(36, 79, 118, 0.15);
    }
    .btn-primary-custom {
        background: linear-gradient(135deg, #447892 0%, #244F76 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        color: #fff;
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
    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 40px;
        color: #244F76;
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
        background: linear-gradient(135deg, #447892 0%, #244F76 100%);
        border-radius: 2px;
    }
</style>

<div class="container mx-auto mt-10">
    <div class="card-annonce p-8 mb-10">
        <h2 class="section-title text-2xl font-bold text-center mb-8">Modifier une annonce</h2>

        @if(session('success'))
        <div class="alert alert-success alert-custom d-flex align-items-center mb-5" role="alert">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-custom d-flex align-items-center mb-5" role="alert">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('proprietaire.annoncesproprietaire.update', $annonce->id) }}" method="POST" enctype="multipart/form-data" id="form-annonce-proprietaire">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">

                {{-- Photos --}}
                <div>
                    <label for="photos_proprietaire" class="form-label">Photos (plusieurs possibles)</label>
                    <input type="file" name="photos[]" id="photos_proprietaire" multiple accept="image/jpeg,image/png,image/jpg" class="form-control">
                    @error('photos.*')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @error('photos')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if($annonce->logement->photos)
                        <div class="mt-2">
                            @foreach(json_decode($annonce->logement->photos, true) as $photo)
                                <img src="{{ asset($photo) }}" width="100" class="img-thumbnail mr-2">
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Titre --}}
                <div>
                    <label for="titre_anno_proprietaire" class="form-label">Titre</label>
                    <input type="text" name="titre_anno" id="titre_anno_proprietaire" class="form-control" value="{{ old('titre_anno', $annonce->titre_anno) }}" required>
                    @error('titre_anno')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Prix --}}
                <div>
                    <label for="prix_log_proprietaire" class="form-label">Prix</label>
                    <input type="number" name="prix_log" id="prix_log_proprietaire" class="form-control" value="{{ old('prix_log', $annonce->logement->prix_log) }}" required>
                    @error('prix_log')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Localisation --}}
                <div>
                    <label for="localisation_log_proprietaire" class="form-label">Localisation</label>
                    <input type="text" name="localisation_log" id="localisation_log_proprietaire" class="form-control" value="{{ old('localisation_log', $annonce->logement->localisation_log) }}" required>
                    @error('localisation_log')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ville --}}
                <div class="mb-3">
                    <label for="ville_proprietaire" class="form-label">Ville</label>
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
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Équipements --}}
                <div>
                    <label class="form-label">Équipements</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(['Wi-Fi','Climatisation/Chauffage','Télévision','Machine à laver','Cuisine équipée','Réfrigérateur','Douche/Baignoire','Parking','Draps et serviettes fournies','Balcon/Terrasse'] as $equipement)
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="{{ $equipement }}" class="form-checkbox" {{ in_array($equipement, old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">{{ $equipement }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('equipements')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="flex justify-center mt-8">
                <button type="submit" class="btn-primary-custom">
                    Mettre à jour l'annonce
                </button>
            </div>
        </form>
    </div>
</div>

@endsection