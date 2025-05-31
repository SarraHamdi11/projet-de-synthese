@extends('layouts.app')

@section('content')

<div class="container mx-auto mt-10">
    <div class="bg-white shadow-md rounded-lg p-8 mb-10">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-8">Modifier une annonce</h2>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('proprietaire.annoncesproprietaire.update', $annonce->id) }}" method="POST" enctype="multipart/form-data" id="form-annonce-proprietaire">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">

                {{-- Photos --}}
                <div>
                    <label for="photos_proprietaire" class="block mb-2 font-semibold text-gray-700">Photos (plusieurs possibles)</label>
                    <input type="file" name="photos[]" id="photos_proprietaire" multiple accept="image/jpeg,image/png,image/jpg" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 file:bg-blue-600 file:text-white file:font-semibold file:px-4 file:py-2 file:rounded file:border-0 file:cursor-pointer">
                    @error('photos.*')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @error('photos')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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
                    <label for="titre_anno_proprietaire" class="block mb-2 font-semibold text-gray-700">Titre</label>
                    <input type="text" name="titre_anno" id="titre_anno_proprietaire" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" value="{{ old('titre_anno', $annonce->titre_anno) }}" required>
                    @error('titre_anno')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Prix --}}
                <div>
                    <label for="prix_log_proprietaire" class="block mb-2 font-semibold text-gray-700">Prix</label>
                    <input type="number" name="prix_log" id="prix_log_proprietaire" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" value="{{ old('prix_log', $annonce->logement->prix_log) }}" required>
                    @error('prix_log')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Localisation --}}
                <div>
                    <label for="localisation_log_proprietaire" class="block mb-2 font-semibold text-gray-700">Localisation</label>
                    <input type="text" name="localisation_log" id="localisation_log_proprietaire" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" value="{{ old('localisation_log', $annonce->logement->localisation_log) }}" required>
                    @error('localisation_log')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Équipements --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">Équipements</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="Wi-Fi" class="form-checkbox" {{ in_array('Wi-Fi', old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">Wi-Fi</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="Climatisation/Chauffage" class="form-checkbox" {{ in_array('Climatisation/Chauffage', old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">Climatisation/Chauffage</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="Télévision" class="form-checkbox" {{ in_array('Télévision', old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">Télévision</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="Machine à laver" class="form-checkbox" {{ in_array('Machine à laver', old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">Machine à laver</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="Cuisine équipée" class="form-checkbox" {{ in_array('Cuisine équipée', old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">Cuisine équipée</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="Réfrigérateur" class="form-checkbox" {{ in_array('Réfrigérateur', old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">Réfrigérateur</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="Douche/Baignoire" class="form-checkbox" {{ in_array('Douche/Baignoire', old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">Douche/Baignoire</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="Parking" class="form-checkbox" {{ in_array('Parking', old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">Parking</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="Draps et serviettes fournies" class="form-checkbox" {{ in_array('Draps et serviettes fournies', old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">Draps et serviettes fournies</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="equipements[]" value="Balcon/Terrasse" class="form-checkbox" {{ in_array('Balcon/Terrasse', old('equipements', json_decode($annonce->logement->equipements ?? '[]', true))) ? 'checked' : '' }}>
                                <span class="ml-2">Balcon/Terrasse</span>
                            </label>
                        </div>
                    </div>
                    @error('equipements')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="flex justify-center mt-8">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-black font-bold py-2 px-8 rounded">
                    Mettre à jour l'annonce
                </button>
            </div>
        </form>
    </div>
</div>

@endsection