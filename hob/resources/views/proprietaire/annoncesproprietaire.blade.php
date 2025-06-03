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

    {{-- Formulaire: Propriétaire --}}
    <div class="card shadow-md rounded-lg mb-5">
        <div class="card-body p-5">
            <h2 class="text-center mb-4 fw-bold text-primary">Créer une annonce :</h2>

            <form action="{{ route('proprietaire.annoncesproprietaire.store') }}" method="POST" enctype="multipart/form-data" id="form-annonce-proprietaire">
                @csrf

                <div class="mb-3">
                    <label for="photos_proprietaire" class="form-label fw-semibold">Photos (plusieurs possibles)</label>
                    <input type="file" name="photos[]" id="photos_proprietaire" multiple accept="image/jpeg,image/png,image/jpg" class="form-control">
                    @error('photos.*')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    @error('photos')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="titre_anno_proprietaire" class="form-label fw-semibold">Titre</label>
                    <input type="text" name="titre_anno" id="titre_anno_proprietaire" class="form-control" value="{{ old('titre_anno') }}" required>
                    @error('titre_anno')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prix_log_proprietaire" class="form-label fw-semibold">Prix</label>
                    <input type="number" name="prix_log" id="prix_log_proprietaire" class="form-control" value="{{ old('prix_log') }}" required>
                    @error('prix_log')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="localisation_log_proprietaire" class="form-label fw-semibold">Localisation</label>
                    <input type="text" name="localisation_log" id="localisation_log_proprietaire" class="form-control" value="{{ old('localisation_log') }}" required>
                    @error('localisation_log')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type_log_proprietaire" class="form-label fw-semibold">Type de logement</label>
                    <select name="type_log" id="type_log_proprietaire" class="form-control" required>
                        <option value="appartement" {{ old('type_log') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                        <option value="studio" {{ old('type_log') == 'studio' ? 'selected' : '' }}>Studio</option>
                        <option value="maison" {{ old('type_log') == 'maison' ? 'selected' : '' }}>Maison</option>
                    </select>
                    @error('type_log')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ville_proprietaire" class="form-label fw-semibold">Ville</label>
                    <input type="text" name="ville" id="ville_proprietaire" class="form-control" value="{{ old('ville') }}" required>
                    @error('ville')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nombre_colocataire_log_proprietaire" class="form-label fw-semibold">Nombre de colocataires</label>
                    <input type="number" name="nombre_colocataire_log" id="nombre_colocataire_log_proprietaire" class="form-control" value="{{ old('nombre_colocataire_log', 1) }}" min="1" required>
                    @error('nombre_colocataire_log')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="etage_proprietaire" class="form-label fw-semibold">Étage (optionnel)</label>
                    <input type="number" name="etage" id="etage_proprietaire" class="form-control" value="{{ old('etage') }}" min="0">
                    @error('etage')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Équipements</label>
                    <div class="row">
                        @foreach(['Wi-Fi', 'Climatisation/Chauffage', 'Télévision', 'Machine à laver', 'Cuisine équipée', 'Réfrigérateur', 'Douche/Baignoire', 'Parking', 'Draps et serviettes fournies', 'Balcon/Terrasse'] as $equipement)
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="equipements[]" value="{{ $equipement }}" class="form-check-input" {{ in_array($equipement, old('equipements', [])) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $equipement }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('equipements')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg">Créer le logement</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Liste des annonces --}}
    <h2 class="text-center mb-5 fw-bold text-primary" style="font-size: 28px;">Liste des annonces</h2>

    <div class="container">
        <div class="row" id="annonces-container">
            @isset($annonces)
            @forelse ($annonces as $annonce)
            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold fs-4 mb-3 text-lowercase">{{ $annonce->titre_anno }}</h5>
                        @if($annonce->logement && $annonce->logement->photos)
                            <div class="slider mb-3">
                                @php
                                    $photos = json_decode($annonce->logement->photos, true);
                                @endphp
                                @foreach($photos as $photo)
                                    <div>
                                        <img src="{{ asset($photo) }}" alt="Photo de l'annonce" class="rounded w-100" style="height: 150px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-3">Aucune photo disponible</p>
                        @endif
                        <div class="mb-3">
                            <p class="mb-1"><span class="me-2">💰</span><strong>Prix:</strong> {{ $annonce->logement->prix_log }} DH/mois</p>
                            <p class="mb-1"><span class="me-2">📍</span><strong>Localisation:</strong> {{ $annonce->logement->localisation_log }}</p>
                            <p class="mb-1"><span class="me-2">🟢</span><strong>Statut:</strong> {{ ucfirst($annonce->statut_anno) }}</p>
                            @if($annonce->date_publication_anno)
                            <p class="mb-1"><span class="me-2">🗓</span><strong>Publiée le:</strong> {{ \Carbon\Carbon::parse($annonce->date_publication_anno)->format('d F Y') }}</p>
                            @endif
                            @if($annonce->logement->equipements)
                            <p class="mb-1"><span class="me-2">🛠</span><strong>Équipements:</strong> {{ implode(', ', json_decode($annonce->logement->equipements, true)) }}</p>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between mt-auto">
                            <a href="{{ route('proprietaire.modifierannonceproprietaire', $annonce->id) }}" class="btn text-dark fw-bold px-3 flex-fill mx-1" style="background-color: #EBDFD5;">
                                Modifier
                            </a>
                            <form action="{{ route('proprietaire.annoncesproprietaire.destroy', $annonce->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression?');" class="flex-fill mx-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn text-dark fw-bold px-3 w-100" style="background-color: #EBDFD5;">
                                    Supprimer
                                </button>
                            </form>
                            <a href="#" class="btn text-dark fw-bold px-3 flex-fill mx-1" style="background-color: #EBDFD5;">
                                Gérer demandes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted">Aucune annonce disponible.</p>
            @endforelse
            @endisset
        </div>

        {{-- ✅ Pagination مخصصة --}}
        @if($annonces->hasPages())
        <div class="mt-5 text-center">
            <nav aria-label="Pagination">
                <ul class="pagination justify-content-center">
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

</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });
</script>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('form-annonce-proprietaire');

        if (!form) {
            console.error('Formulaire #form-annonce-proprietaire introuvable');
            return;
        }

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(form);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

            try {
                const response = await axios.post("{{ route('proprietaire.annoncesproprietaire.store') }}", formData, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const json = response.data;

                if (json.success) {
                    const equipementsList = json.annonce.logement.equipements ? JSON.parse(json.annonce.logement.equipements).join(', ') : '';
                    const photosList = json.annonce.logement.photos ? JSON.parse(json.annonce.logement.photos) : [];
                    const firstPhoto = photosList[0] || null;
                    const photosHtml = firstPhoto
                        ? `<div class="mb-3"><img src="/${firstPhoto}" alt="Photo de l'annonce" class="rounded w-100" style="height: 150px; object-fit: cover;"></div>`
                        : `<p class="text-muted mb-3">Aucune photo disponible</p>`;

                    const newCard = `
                        <div class="col-md-4 mb-4 d-flex align-items-stretch">
                            <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold fs-4 mb-3 text-lowercase">${json.annonce.titre_anno}</h5>
                                    ${photosHtml}
                                    <div class="mb-3">
                                        <p class="mb-1"><span class="me-2">💰</span><strong>Prix:</strong> ${json.annonce.logement.prix_log} DH/mois</p>
                                        <p class="mb-1"><span class="me-2">📍</span><strong>Localisation:</strong> ${json.annonce.logement.localisation_log}</p>
                                        <p class="mb-1"><span class="me-2">🟢</span><strong>Statut:</strong> ${json.annonce.statut_anno.charAt(0).toUpperCase() + json.annonce.statut_anno.slice(1)}</p>
                                        ${json.annonce.date_publication_anno ? `<p class="mb-1"><span class="me-2">🗓</span><strong>Publiée le:</strong> ${new Date(json.annonce.date_publication_anno).toLocaleDateString('fr-FR')}</p>` : ''}
                                        ${equipementsList ? `<p class="mb-1"><span class="me-2">🛠</span><strong>Équipements:</strong> ${equipementsList}</p>` : ''}
                                    </div>
                                    <div class="d-flex justify-content-between mt-auto">
                                        <a href="{{ route('proprietaire.modifierannonceproprietaire', ':id') }}".replace(':id', json.annonce.id)" class="btn text-dark fw-bold px-3 flex-fill mx-1" style="background-color: #EBDFD5;">
                                            Modifier
                                        </a>
                                        <form action="{{ route('proprietaire.annoncesproprietaire.destroy', ':id') }}".replace(':id', json.annonce.id)" method="POST" onsubmit="return confirm('Confirmer la suppression?');" class="flex-fill mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn text-dark fw-bold px-3 w-100" style="background-color: #EBDFD5;">
                                                Supprimer
                                            </button>
                                        </form>
                                        <a href="#" class="btn text-dark fw-bold px-3 flex-fill mx-1" style="background-color: #EBDFD5;">
                                            Gérer demandes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    const annoncesContainer = document.querySelector('#annonces-container');
                    if (annoncesContainer) {
                        annoncesContainer.insertAdjacentHTML('afterbegin', newCard);
                    } else {
                        console.error('Conteneur #annonces-container introuvable');
                    }

                    form.reset();
                    alert(json.message || 'Annonce créée avec succès !');

                    // ✅ تحديث الصفحة باش الـ pagination تتحدث
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert('Erreur: ' + json.message);
                }

            } catch (error) {
                console.error('Erreur détaillée:', error);
                if (error.response) {
                    const status = error.response.status;
                    const data = error.response.data;
                    let errorMessage = `Erreur ${status}: `;
                    if (status === 422) {
                        errorMessage += Object.values(data.errors || {}).flat().join('\n') || data.message;
                    } else {
                        errorMessage += data.message || 'Problème de connexion ou serveur.';
                    }
                    alert(errorMessage);
                } else {
                    alert('Erreur: Vérifiez la console pour plus de détails.');
                }
            }
        });
    });
</script>
@endsection