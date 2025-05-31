@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-10">
    {{-- Message succès --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-bs-dismiss="alert" aria-label="Close">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </button>
    </div>
    @endif

    {{-- Message erreur --}}
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-bs-dismiss="alert" aria-label="Close">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </button>
    </div>
    @endif

    {{-- Formulaire création --}}
    <div class="bg-white shadow-xl rounded-xl p-6 md:p-8 mb-8">
        <h2 class="text-center mb-8 text-3xl font-bold" style="font-family: 'Inknut Antiqua', serif; color: #244F76;">Créer une annonce</h2>

        <form id="form-annonce" method="POST" action="{{ route('locataire.annoncelocataire.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <label for="titre_anno" class="block mb-2 text-sm font-semibold text-gray-700">Titre</label>
                    <input type="text" name="titre_anno" id="titre_anno" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-300 p-2.5" value="{{ old('titre_anno') }}" required>
                    @error('titre_anno')
                        <small class="text-red-500 mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="type_log" class="block mb-2 text-sm font-semibold text-gray-700">Type de logement</label>
                    <select name="type_log" id="type_log" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-300 p-2.5" required>
                        <option value="studio" {{ old('type_log') == 'studio' ? 'selected' : '' }}>Studio</option>
                        <option value="appartement" {{ old('type_log') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                        <option value="maison" {{ old('type_log') == 'maison' ? 'selected' : '' }}>Maison</option>
                    </select>
                    @error('type_log')
                        <small class="text-red-500 mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="prix_log" class="block mb-2 text-sm font-semibold text-gray-700">Budget (MAD/mois)</label>
                    <input type="number" name="prix_log" id="prix_log" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-300 p-2.5" value="{{ old('prix_log') }}" required>
                    @error('prix_log')
                        <small class="text-red-500 mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="ville" class="block mb-2 text-sm font-semibold text-gray-700">Ville</label>
                    <input type="text" name="ville" id="ville" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-300 p-2.5" value="{{ old('ville') }}" required>
                    @error('ville')
                        <small class="text-red-500 mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="nombre_colocataire_log" class="block mb-2 text-sm font-semibold text-gray-700">Nombre de colocataires</label>
                    <input type="number" name="nombre_colocataire_log" id="nombre_colocataire_log" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-300 p-2.5" value="{{ old('nombre_colocataire_log') }}" required>
                    @error('nombre_colocataire_log')
                        <small class="text-red-500 mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="localisation_log" class="block mb-2 text-sm font-semibold text-gray-700">Localisation</label>
                    <input type="text" name="localisation_log" id="localisation_log" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-300 p-2.5" value="{{ old('localisation_log') }}" required>
                    @error('localisation_log')
                        <small class="text-red-500 mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="photos_locataire" class="block mb-2 text-sm font-semibold text-gray-700">Photos (plusieurs possibles)</label>
                    <input type="file" name="photos[]" id="photos_locataire" multiple accept="image/jpeg,image/png,image/jpg" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-300 p-2.5">
                    @error('photos.*')
                        <small class="text-red-500 mt-1">{{ $message }}</small>
                    @enderror
                    @error('photos')
                        <small class="text-red-500 mt-1">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-span-1 md:col-span-2">
                <label for="description_anno" class="block mb-2 text-sm font-semibold text-gray-700">Description</label>
                <textarea name="description_anno" id="description_anno" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-300 p-2.5" required>{{ old('description_anno') }}</textarea>
                @error('description_anno')
                    <small class="text-red-500 mt-1">{{ $message }}</small>
                @enderror
            </div>
            <div class="text-center pt-4">
                {{-- Couleur du bouton Lancer l'annonce mise à jour --}}
                <button type="submit" class="text-white font-semibold px-8 py-3 rounded-lg hover:bg-green-700 transition duration-300" style="background-color: #047857;">Lancer l'annonce</button>
            </div>
        </form>
    </div>

    {{-- Liste des annonces --}}
    <h2 class="text-center mb-10 text-3xl font-bold" style="font-family: 'Inknut Antiqua', serif; color: #244F76;">Liste des annonces</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="annoncesList">
        @if(isset($annonces) && $annonces->count() > 0)
            @forelse ($annonces as $annonce)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                    <div class="p-6 flex flex-col flex-grow">
                        <div>
                            <h5 class="text-xl font-bold mb-3 capitalize" style="font-family: 'Inknut Antiqua', serif; color: #244F76;">{{ $annonce->titre_anno }}</h5>
                            <div class="space-y-2 text-sm text-gray-600 mb-4">
                                <p class="line-clamp-3">{{ $annonce->description_anno }}</p>
                                <p><span class="mr-2">💰</span><strong>Prix:</strong> {{ $annonce->logement->prix_log ?? 'N/A' }} MAD/mois</p>
                                <p><span class="mr-2">📍</span><strong>Localisation:</strong> {{ $annonce->logement->localisation_log ?? 'N/A' }}</p>
                                <p><span class="mr-2">🗓</span><strong>Publiée le:</strong> {{ \Carbon\Carbon::parse($annonce->date_publication_anno)->isoFormat('D MMMM YYYY') }}</p>
                                <p><span class="mr-2">👥</span><strong>Nombre de colocataires:</strong> {{ $annonce->logement->nombre_colocataire_log ?? 'N/A' }}</p>
                                <p><span class="mr-2">🏠</span><strong>Type:</strong> {{ $annonce->logement->type_log ?? 'N/A' }}</p>
                                <p><span class="mr-2">🌆</span><strong>Ville:</strong> {{ $annonce->logement->ville ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="mt-auto pt-4 flex gap-3">
                            {{-- Couleur du bouton Modifier mise à jour --}}
                            <a href="{{ route('locataire.modifierannoncelocataire.edit', $annonce->id) }}" class="flex-1 text-center text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-300 hover:opacity-90" style="background-color: #EBDFD5;">
                                Modifier
                            </a>
                            <form action="{{ route('locataire.annoncelocataire.destroy', $annonce->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression?');" class="flex-1">
                                @csrf
                                @method('DELETE')
                                {{-- Couleur du bouton Supprimer mise à jour --}}
                                <button type="submit" class="w-full text-center text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-300 hover:opacity-90" style="background-color: #EBDFD5;">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500 py-10">
                    <p class="text-xl">Aucune annonce disponible pour le moment.</p>
                </div>
            @endforelse
        @else
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500 py-10">
                <p class="text-xl">Aucune annonce disponible pour le moment.</p>
            </div>
        @endif
    </div>

    {{-- Pagination personnalisée --}}
    @if(isset($annonces) && $annonces->hasPages())
    <div class="mt-12 flex justify-center">
        <nav aria-label="Pagination">
            <ul class="inline-flex items-center -space-x-px">
                <li>
                    <a href="{{ $annonces->previousPageUrl() }}" class="py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 {{ $annonces->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                        Précédent
                    </a>
                </li>
                @foreach($annonces->getUrlRange(1, $annonces->lastPage()) as $page => $url)
                <li>
                    <a href="{{ $url }}" class="py-2 px-3 leading-tight {{ $page == $annonces->currentPage() ? 'text-blue-600 bg-blue-50 border border-blue-300 hover:bg-blue-100 hover:text-blue-700' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">
                        {{ $page }}
                    </a>
                </li>
                @endforeach
                <li>
                    <a href="{{ $annonces->nextPageUrl() }}" class="py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 {{ $annonces->hasMorePages() ? '' : 'opacity-50 cursor-not-allowed' }}">
                        Suivant
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-annonce');

    if (!form) {
        // console.error('Formulaire #form-annonce introuvable'); // Vous pouvez décommenter pour le débogage
        return;
    }

    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(form);
        // CSRF token est déjà inclus via @csrf dans le formulaire, pas besoin de l'ajouter ici via JS si le formulaire est soumis normalement.
        // Si vous faites une requête AJAX pure sans soumission de formulaire, alors oui, il faut l'ajouter.

        try {
            // La route est déjà dans l'attribut action du formulaire
            const response = await axios.post(form.action, formData, {
                headers: {
                    'Accept': 'application/json',
                    // 'X-Requested-With': 'XMLHttpRequest', // Axios ajoute cela par défaut
                    // 'Content-Type': 'multipart/form-data', // Axios détecte cela à partir de FormData
                }
            });

            const json = response.data;

            if (json.success && json.annonce) {
                // Logique pour ajouter la nouvelle annonce à la liste dynamiquement
                // Cette partie dépendra de la structure exacte de votre json.annonce
                // et de comment vous voulez l'afficher.
                // Par exemple, recharger la page ou injecter l'HTML.
                // Pour l'instant, affichons un message et rechargeons la page pour la simplicité.
                alert(json.message || 'Annonce créée avec succès!');
                window.location.reload(); 
            } else {
                // Gérer les erreurs de validation ou autres problèmes
                let errorMessage = json.message || 'Une erreur est survenue.';
                if (json.errors) {
                    errorMessage += '\n' + Object.values(json.errors).flat().join('\n');
                }
                alert(errorMessage);
            }

        } catch (error) {
            console.error('Erreur lors de la soumission du formulaire:', error);
            let errorText = 'Une erreur réseau est survenue.';
            if (error.response && error.response.data && error.response.data.message) {
                errorText = error.response.data.message;
                if (error.response.data.errors) {
                    errorText += '\n' + Object.values(error.response.data.errors).flat().join('\n');
                }
            }
            alert(errorText);
        }
    });
});
</script>
@endpush