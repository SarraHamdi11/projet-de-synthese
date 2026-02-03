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

.btn-primary {
    background: linear-gradient(135deg, #7C9FC0 0%, #24507a 100%);
    border: none;
    border-radius: 10px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.section-title {
    color: #24507a;
    font-weight: 700;
    margin-bottom: 1rem;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Mes Annonces</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAnnonceModal">
                        <i class="fas fa-plus"></i> Créer une annonce
                    </button>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- Create Annonce Modal -->
                    <div class="modal fade" id="createAnnonceModal" tabindex="-1" aria-labelledby="createAnnonceModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createAnnonceModalLabel">
                                        <i class="fas fa-plus-circle me-2"></i>Créer une nouvelle annonce
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('proprietaire.annonces.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Sélectionner un logement *</label>
                                            @php
                                                $logements = \App\Models\Logement::where('proprietaire_id', auth()->user()->id)->get();
                                            @endphp
                                            <select name="logement_id" class="form-select" required>
                                                <option value="">Choisir un logement...</option>
                                                @forelse($logements as $logement)
                                                    <option value="{{ $logement->id }}">
                                                        {{ $logement->titre_log ?? 'Logement #' . $logement->id }} - {{ $logement->prix_log ?? 0 }} DH/mois
                                                    </option>
                                                @empty
                                                    <option value="" disabled>Aucun logement disponible</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Titre de l'annonce *</label>
                                            <input type="text" name="titre_anno" class="form-control" required placeholder="Ex: Appartement moderne centre-ville">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Description *</label>
                                            <textarea name="description_anno" rows="4" class="form-control" required placeholder="Décrivez votre logement..."></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Disponibilité *</label>
                                            <select name="disponibilite_annonce" class="form-select" required>
                                                <option value="">Sélectionner...</option>
                                                <option value="1">Disponible immédiatement</option>
                                                <option value="0">Non disponible</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Photos (optionnel)</label>
                                            <input type="file" name="photos[]" multiple accept="image/jpeg,image/png,image/jpg" class="form-control">
                                            <small class="text-muted">Formats: JPG, PNG. Plusieurs photos possibles.</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Créer l'annonce
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @forelse($annonces as $annonce)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    @if($annonce->logement && $annonce->logement->photos)
                                        @php $photos = is_array($annonce->logement->photos) ? $annonce->logement->photos : json_decode($annonce->logement->photos, true); @endphp
                                        @if(is_array($photos) && count($photos) > 0)
                                            <img src="{{ asset($photos[0]) }}" class="card-img-top" alt="Photo" style="height: 200px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Photo" style="height: 200px; object-fit: cover;">
                                        @endif
                                    @else
                                        <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Photo" style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $annonce->titre_anno }}</h5>
                                        <p class="card-text">{{ Str::limit($annonce->description_anno, 100) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge {{ $annonce->disponibilite_annonce ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $annonce->disponibilite_annonce ? 'Disponible' : 'Non disponible' }}
                                            </span>
                                            <small class="text-muted">{{ $annonce->created_at->format('d/m/Y') }}</small>
                                                <i class="fas fa-edit"></i> Modifier
                                            </a>
                                            <form action="{{ route('proprietaire.annoncesproprietaire.destroy', $annonce->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                                    <i class="fas fa-trash"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    Vous n'avez pas encore d'annonces. Créez-en une nouvelle !
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .carousel-item img {
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }
    .carousel-control-prev,
    .carousel-control-next {
        width: 10%;
        opacity: 0.8;
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        padding: 1rem;
    }
</style>
@endpush
@endsection 