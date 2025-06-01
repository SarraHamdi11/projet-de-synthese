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
    <h2 class="mb-4" style="color:#244F76; font-weight:bold; font-size:2rem; text-align:left;">Creer une annonce :</h2>
    <div class="card shadow-lg rounded-4 border-0 mb-8 mx-auto" style="background: #fff; max-width: 700px;">
      <div class="card-body p-4 p-md-5">
        <form id="form-annonce" method="POST" action="{{ route('locataire.annoncelocataire.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="row g-4">
            <div class="col-md-6">
              <label for="titre_anno" class="form-label">Titre</label>
              <input type="text" name="titre_anno" id="titre_anno" class="form-control rounded-3" style="border: 1.5px solid #244F76;" value="{{ old('titre_anno') }}" required>
              @error('titre_anno')
                <small class="text-danger mt-1">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="type_log" class="form-label">Type de logement</label>
              <select name="type_log" id="type_log" class="form-control rounded-3" style="border: 1.5px solid #244F76;" required>
                <option value="studio" {{ old('type_log') == 'studio' ? 'selected' : '' }}>Studio</option>
                <option value="appartement" {{ old('type_log') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                <option value="maison" {{ old('type_log') == 'maison' ? 'selected' : '' }}>Maison</option>
              </select>
              @error('type_log')
                <small class="text-danger mt-1">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="prix_log" class="form-label">Budget (MAD/mois)</label>
              <input type="number" name="prix_log" id="prix_log" class="form-control rounded-3" style="border: 1.5px solid #244F76;" value="{{ old('prix_log') }}" required>
              @error('prix_log')
                <small class="text-danger mt-1">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="ville" class="form-label">Ville</label>
              <select name="ville" id="ville" class="form-control rounded-3" style="border: 1.5px solid #244F76;" required>
                <option value="">Sélectionnez une ville</option>
                <option value="Tétouan" {{ old('ville') == 'Tétouan' ? 'selected' : '' }}>Tétouan</option>
                <option value="Tanger" {{ old('ville') == 'Tanger' ? 'selected' : '' }}>Tanger</option>
                <option value="Martil" {{ old('ville') == 'Martil' ? 'selected' : '' }}>Martil</option>
                <option value="Rincon" {{ old('ville') == 'Rincon' ? 'selected' : '' }}>Rincon</option>
                <option value="Hoceima" {{ old('ville') == 'Hoceima' ? 'selected' : '' }}>Hoceima</option>
                <option value="Chaouen" {{ old('ville') == 'Chaouen' ? 'selected' : '' }}>Chaouen</option>
              </select>
              @error('ville')
                <small class="text-danger mt-1">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="nombre_colocataire_log" class="form-label">Nombre de colocataires</label>
              <input type="number" name="nombre_colocataire_log" id="nombre_colocataire_log" class="form-control rounded-3" style="border: 1.5px solid #244F76;" value="{{ old('nombre_colocataire_log') }}" required>
              @error('nombre_colocataire_log')
                <small class="text-danger mt-1">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="localisation_log" class="form-label">Localisation</label>
              <input type="text" name="localisation_log" id="localisation_log" class="form-control rounded-3" style="border: 1.5px solid #244F76;" value="{{ old('localisation_log') }}" required>
              @error('localisation_log')
                <small class="text-danger mt-1">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="photos_locataire" class="form-label">Photos (plusieurs possibles)</label>
              <input type="file" name="photos[]" id="photos_locataire" multiple accept="image/jpeg,image/png,image/jpg" class="form-control rounded-3" style="border: 1.5px solid #244F76;">
              @error('photos.*')
                <small class="text-danger mt-1">{{ $message }}</small>
              @enderror
              @error('photos')
                <small class="text-danger mt-1">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-12">
              <label for="description_anno" class="form-label">Description</label>
              <textarea name="description_anno" id="description_anno" rows="4" class="form-control rounded-3" style="border: 1.5px solid #244F76;" required>{{ old('description_anno') }}</textarea>
              @error('description_anno')
                <small class="text-danger mt-1">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="d-grid mt-4">
            <button type="submit" class="btn" style="background:#21825C; color:#fff; font-weight:600;">Publier l'annonce</button>
          </div>
        </form>
      </div>
    </div>

    {{-- Liste des annonces --}}
    <h2 class="text-center mb-10 text-3xl font-bold" style="font-family: 'Inknut Antiqua', serif; color: #244F76;">Liste des annonces</h2>

    <div class="row" id="annoncesList">
      @if(isset($annonces) && $annonces->count() > 0)
        @foreach ($annonces as $annonce)
          <div class="col-md-4 mb-4">
            <div class="bg-white rounded-4 border" style="border: 1.5px solid #244F76;">
              <div class="p-4 d-flex flex-column h-100">
                {{-- Photo slider --}}
                @php
                  $photos = $annonce->logement && $annonce->logement->photos ? json_decode($annonce->logement->photos, true) : [];
                  $carouselId = 'carouselAnnonce' . $annonce->id;
                @endphp
                <div class="mb-3">
                  @if($photos && count($photos) > 0)
                    <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-inner rounded-3" style="height:180px;overflow:hidden;">
                        @foreach($photos as $idx => $photo)
                          <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                            <img src="{{ asset($photo) }}" class="d-block w-100 h-100 object-fit-cover" alt="Photo logement" style="object-fit:cover;max-height:180px;">
                          </div>
                        @endforeach
                      </div>
                      @if(count($photos) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                        </button>
                      @endif
                    </div>
                  @else
                    <img src="{{ asset('images/default.jpg') }}" class="d-block w-100 rounded-3" alt="Photo logement" style="object-fit:cover;max-height:180px;">
                  @endif
                </div>
                <div>
                  <h5 class="mb-2" style="font-weight:bold; font-size:1.1rem; color:#244F76;">{{ $annonce->titre_anno }}</h5>
                  <div class="mb-2" style="font-size:0.97rem;">{{ $annonce->description_anno }}</div>
                  <div class="mb-1" style="font-size:0.93rem;"><span class="me-2">💰</span><strong>Prix:</strong> {{ $annonce->logement->prix_log ?? 'N/A' }} MAD/mois</div>
                  <div class="mb-1" style="font-size:0.93rem;"><span class="me-2">📍</span><strong>Localisation:</strong> {{ $annonce->logement->localisation_log ?? 'N/A' }}</div>
                  <div class="mb-1" style="font-size:0.93rem;"><span class="me-2">🗓</span><strong>Publiée le:</strong> {{ \Carbon\Carbon::parse($annonce->date_publication_anno)->isoFormat('D MMM YYYY') }}</div>
                </div>
                <div class="mt-3 d-flex gap-2">
                  <a href="{{ route('locataire.modifierannoncelocataire.edit', $annonce->id) }}" class="btn btn-sm" style="background:#EBDFD5; color:#244F76; font-weight:600;">Modifier</a>
                  <form action="{{ route('locataire.annoncelocataire.destroy', $annonce->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm" style="background:#EBDFD5; color:#244F76; font-weight:600;">Supprimer</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      @else
        <div class="col-12 text-center text-gray-500 py-10">
          <p class="text-xl">Aucune annonce disponible pour le moment.</p>
        </div>
      @endif
    </div>

    {{-- Pagination Bootstrap --}}
    @if(isset($annonces) && $annonces->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        <nav>
            <ul class="pagination">
                <li class="page-item {{ $annonces->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $annonces->previousPageUrl() }}">Précédent</a>
                </li>
                @foreach($annonces->getUrlRange(1, $annonces->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $annonces->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
                @endforeach
                <li class="page-item {{ $annonces->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $annonces->nextPageUrl() }}">Suivant</a>
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