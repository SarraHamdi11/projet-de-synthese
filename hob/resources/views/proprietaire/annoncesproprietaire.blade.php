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
    
    .form-control, .form-select, .form-check-input {
        border: 2px solid rgba(36, 79, 118, 0.2);
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .form-control:hover, .form-select:hover, .form-check-input:hover {
        border-color: #7C9FC0;
    }
    
    .form-check-input {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0.25em;
    }
    
    .form-check-label {
        color: #244F76;
        font-size: 14px;
        margin-left: 8px;
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
    
    /* Styles pour la liste des annonces (non modifiés, conservés tels quels) */
    .card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .pagination .page-link {
        color: #244F76;
        border: 1px solid rgba(36, 79, 118, 0.2);
        border-radius: 10px;
        margin: 0 3px;
        font-weight: 500;
    }
    
    .pagination .page-item.active .page-link {
        background: #447892;
        border-color: #447892;
        color: white;
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

    {{-- Formulaire de création avec design professionnel --}}
    <div class="text-center mb-5">
        <h2 class="title-font section-title" style="color:#244F76; font-weight:700; font-size:2.5rem;">
            Créer une annonce
        </h2>
        <p class="text-muted mt-3" style="font-size: 1.1rem;">Publiez votre annonce de colocation en quelques clics</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="professional-card p-4 p-md-5">
                <form action="{{ route('proprietaire.annoncesproprietaire.store') }}" method="POST" enctype="multipart/form-data" id="form-annonce-proprietaire">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="photos_proprietaire" class="form-label">
                                <i class="fas fa-camera me-2"></i>Photos du logement
                            </label>
                            <input type="file" name="photos[]" id="photos_proprietaire" multiple 
                                   accept="image/jpeg,image/png,image/jpg" class="form-control">
                            <small class="text-muted mt-1">Formats acceptés: JPG, PNG. Plusieurs photos possibles.</small>
                            @error('photos.*')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                            @error('photos')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="titre_anno_proprietaire" class="form-label">
                                <i class="fas fa-heading me-2"></i>Titre de l'annonce
                            </label>
                            <input type="text" name="titre_anno" id="titre_anno_proprietaire" class="form-control" 
                                   value="{{ old('titre_anno') }}" required placeholder="Ex: Colocation sympa centre-ville">
                            @error('titre_anno')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="prix_log_proprietaire" class="form-label">
                                <i class="fas fa-coins me-2"></i>Prix mensuel (MAD)
                            </label>
                            <input type="number" name="prix_log" id="prix_log_proprietaire" class="form-control" 
                                   value="{{ old('prix_log') }}" required placeholder="Ex: 3000">
                            @error('prix_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="localisation_log_proprietaire" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Localisation précise
                            </label>
                            <input type="text" name="localisation_log" id="localisation_log_proprietaire" class="form-control" 
                                   value="{{ old('localisation_log') }}" required placeholder="Ex: Quartier Hassan">
                            @error('localisation_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="type_log_proprietaire" class="form-label">
                                <i class="fas fa-home me-2"></i>Type de logement
                            </label>
                            <select name="type_log" id="type_log_proprietaire" class="form-select" required>
                                <option value="">Choisissez le type</option>
                                <option value="appartement" {{ old('type_log') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                <option value="studio" {{ old('type_log') == 'studio' ? 'selected' : '' }}>Studio</option>
                                <option value="maison" {{ old('type_log') == 'maison' ? 'selected' : '' }}>Maison</option>
                            </select>
                            @error('type_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="ville_proprietaire" class="form-label">
                                <i class="fas fa-city me-2"></i>Ville
                            </label>
                            <select name="ville" id="ville_proprietaire" class="form-select" required>
                                <option value="">Sélectionnez une ville</option>
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
                            <label for="nombre_colocataire_log_proprietaire" class="form-label">
                                <i class="fas fa-users me-2"></i>Nombre de colocataires
                            </label>
                            <input type="number" name="nombre_colocataire_log" id="nombre_colocataire_log_proprietaire" class="form-control" 
                                   value="{{ old('nombre_colocataire_log', 1) }}" min="1" required placeholder="Ex: 2">
                            @error('nombre_colocataire_log')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="etage_proprietaire" class="form-label">
                                <i class="fas fa-building me-2"></i>Étage (optionnel)
                            </label>
                            <input type="number" name="etage" id="etage_proprietaire" class="form-control" 
                                   value="{{ old('etage') }}" min="0" placeholder="Ex: 3">
                            @error('etage')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">
                                <i class="fas fa-tools me-2"></i>Équipements
                            </label>
                            <div class="row g-4">
                                @foreach(['Wi-Fi', 'Climatisation/Chauffage', 'Télévision', 'Machine à laver', 'Cuisine équipée', 'Réfrigérateur', 'Douche/Baignoire', 'Parking', 'Draps et serviettes fournies', 'Balcon/Terrasse'] as $equipement)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="equipements[]" value="{{ $equipement }}" class="form-check-input" 
                                               {{ in_array($equipement, old('equipements', [])) ? 'checked' : '' }}>
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
                            <i class="fas fa-paper-plane me-2"></i>Publier l'annonce
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Liste des annonces --}}
    <div class="text-center mb-5">
        <h2 class="title-font section-title" style="color: #244F76; font-size: 2.2rem; font-weight: 700;">
            Mes Annonces
        </h2>
        <p class="text-muted mt-3">Gérez vos annonces de colocation</p>
    </div>

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
        <div class="col-12">
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-home" style="font-size: 4rem; color: #7C9FC0; opacity: 0.5;"></i>
                </div>
                <h4 class="title-font text-muted mb-3">Aucune annonce disponible</h4>
                <p class="text-muted">Créez votre première annonce pour commencer!</p>
            </div>
        </div>
        @endforelse
        @endisset
    </div>

    {{-- Pagination --}}
    @if($annonces->hasPages())
    <div class="mt-5 d-flex justify-content-center">
        <nav aria-label="Pagination">
            <ul class="pagination pagination-lg">
                <li class="page-item {{ $annonces->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $annonces->previousPageUrl() }}">
                        <i class="fas fa-chevron-left me-1"></i>Précédent
                    </a>
                </li>
                @foreach($annonces->getUrlRange(1, $annonces->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $annonces->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
                @endforeach
                <li class="page-item {{ $annonces->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $annonces->nextPageUrl() }}">
                        Suivant<i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
                        // Réinitialiser le slider Slick pour la nouvelle carte
                        $('.slider').slick('unslick');
                        $('.slider').slick({
                            dots: true,
                            infinite: true,
                            speed: 500,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        });
                    } else {
                        console.error('Conteneur #annonces-container introuvable');
                    }

                    // Supprimer le message "Aucune annonce" si présent
                    const noAnnonces = document.querySelector('#annonces-container .text-center');
                    if (noAnnonces) noAnnonces.remove();

                    form.reset();
                    const successDiv = document.createElement('div');
                    successDiv.className = 'alert alert-success alert-custom d-flex align-items-center';
                    successDiv.style.marginBottom = '24px';
                    successDiv.innerHTML = `
                        <svg class="me-3" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div><strong>Succès!</strong> Annonce créée avec succès !</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    const container = document.querySelector('.container');
                    if (container) container.prepend(successDiv);
                    setTimeout(() => successDiv.remove(), 4000);
                } else {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger alert-custom d-flex align-items-center';
                    errorDiv.style.marginBottom = '24px';
                    errorDiv.innerHTML = `
                        <svg class="me-3" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div><strong>Erreur!</strong> ${json.message || 'Une erreur est survenue.'}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    const container = document.querySelector('.container');
                    if (container) container.prepend(errorDiv);
                    setTimeout(() => errorDiv.remove(), 4000);
                }

            } catch (error) {
                console.error('Erreur détaillée:', error);
                let errorMessage = 'Erreur: Problème de connexion ou serveur.';
                if (error.response) {
                    const status = error.response.status;
                    const data = error.response.data;
                    if (status === 422) {
                        errorMessage = Object.values(data.errors || {}).flat().join('\n') || data.message;
                    } else {
                        errorMessage = data.message || 'Problème de connexion ou serveur.';
                    }
                }
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger alert-custom d-flex align-items-center';
                errorDiv.style.marginBottom = '24px';
                errorDiv.innerHTML = `
                    <svg class="me-3" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div><strong>Erreur!</strong> ${errorMessage}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                const container = document.querySelector('.container');
                if (container) container.prepend(errorDiv);
                setTimeout(() => errorDiv.remove(), 4000);
            }
        });
    });
</script>
@endsection