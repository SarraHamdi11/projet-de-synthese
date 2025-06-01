@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    {{-- Message succès --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Message erreur --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Formulaire modification --}}
    <div class="card shadow-md rounded-lg mb-5">
        <div class="card-body p-5">
            <h2 class="text-center mb-8 text-3xl font-bold" style="font-family: 'Inknut Antiqua', serif; color: #244F76">Modifier l'annonce : {{ $annonce->titre_anno }}</h2>

            <form id="form-edit-annonce" method="POST" action="{{ route('locataire.annoncelocataire.update', $annonce->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-3">
                        <label for="titre_anno" class="block mb-2 font-semibold text-gray-700">Titre</label>
                        <input type="text" name="titre_anno" id="titre_anno" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" value="{{ old('titre_anno', $annonce->titre_anno) }}" required>
                        @error('titre_anno')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="type_log" class="block mb-2 font-semibold text-gray-700">Type de logement</label>
                        <select name="type_log" id="type_log" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                            <option value="studio" {{ old('type_log', $annonce->logement->type_log) == 'studio' ? 'selected' : '' }}>Studio</option>
                            <option value="appartement" {{ old('type_log', $annonce->logement->type_log) == 'appartement' ? 'selected' : '' }}>Appartement</option>
                            <option value="maison" {{ old('type_log', $annonce->logement->type_log) == 'maison' ? 'selected' : '' }}>Maison</option>
                        </select>
                        @error('type_log')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="prix_log" class="block mb-2 font-semibold text-gray-700">Budget (MAD/mois)</label>
                        <input type="number" name="prix_log" id="prix_log" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" value="{{ old('prix_log', $annonce->logement->prix_log) }}" required>
                        @error('prix_log')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="ville" class="block mb-2 text-sm font-semibold text-gray-700">Ville</label>
                        <select name="ville" id="ville" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-300 p-2.5" required>
                            <option value="">Sélectionnez une ville</option>
                            <option value="Tétouan" {{ old('ville', $annonce->logement->ville ?? '') == 'Tétouan' ? 'selected' : '' }}>Tétouan</option>
                            <option value="Tanger" {{ old('ville', $annonce->logement->ville ?? '') == 'Tanger' ? 'selected' : '' }}>Tanger</option>
                            <option value="Martil" {{ old('ville', $annonce->logement->ville ?? '') == 'Martil' ? 'selected' : '' }}>Martil</option>
                            <option value="Rincon" {{ old('ville', $annonce->logement->ville ?? '') == 'Rincon' ? 'selected' : '' }}>Rincon</option>
                            <option value="Hoceima" {{ old('ville', $annonce->logement->ville ?? '') == 'Hoceima' ? 'selected' : '' }}>Hoceima</option>
                            <option value="Chaouen" {{ old('ville', $annonce->logement->ville ?? '') == 'Chaouen' ? 'selected' : '' }}>Chaouen</option>
                        </select>
                        @error('ville')
                            <small class="text-red-500 mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nombre_colocataire_log" class="block mb-2 font-semibold text-gray-700">Nombre de colocataires</label>
                        <input type="number" name="nombre_colocataire_log" id="nombre_colocataire_log" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" value="{{ old('nombre_colocataire_log', $annonce->logement->nombre_colocataire_log) }}" required>
                        @error('nombre_colocataire_log')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="localisation_log" class="block mb-2 font-semibold text-gray-700">Localisation</label>
                        <input type="text" name="localisation_log" id="localisation_log" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" value="{{ old('localisation_log', $annonce->logement->localisation_log) }}" required>
                        @error('localisation_log')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description_anno" class="block mb-2 font-semibold text-gray-700">Description</label>
                    <textarea name="description_anno" id="description_anno" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>{{ old('description_anno', $annonce->description_anno) }}</textarea>
                    @error('description_anno')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="text-white font-semibold px-8 py-3 rounded-lg hover:bg-green-700 transition duration-300" style="background-color: #047857;">Mettre à jour l'annonce</button>
                    <a href="{{ route('locataire.annonceslocataire.index') }}" class="text-white font-semibold py-3 px-8 rounded-lg transition duration-300 hover:opacity-90 ms-3" style="background-color: #047857;">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection