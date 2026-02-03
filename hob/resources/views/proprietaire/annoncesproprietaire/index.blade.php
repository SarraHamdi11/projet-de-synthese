@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Mes Annonces</h4>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="createAnnonceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus"></i> Nouvelle Annonce
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="createAnnonceDropdown">
                            @php
                                $logements = \App\Models\Logement::where('proprietaire_id', auth()->user()->id)->get();
                            @endphp
                            @forelse($logements as $logement)
                                <li><a class="dropdown-item" href="{{ route('proprietaire.annonces.create', $logement->id) }}">
                                    <i class="fas fa-home"></i> {{ $logement->titre_log ?? 'Logement #' . $logement->id }}
                                </a></li>
                            @empty
                                <li><span class="dropdown-item text-muted">Aucun logement disponible</span></li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        @forelse($annonces as $annonce)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <!-- Slider d'images -->
                                    <div id="carousel{{ $annonce->id }}" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @if($annonce->images)
                                                @foreach(json_decode($annonce->images) as $index => $image)
                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                        <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="Image {{ $index + 1 }}" style="height: 200px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="carousel-item active">
                                                    <img src="{{ asset('images/default-property.jpg') }}" class="d-block w-100" alt="Default Image" style="height: 200px; object-fit: cover;">
                                                </div>
                                            @endif
                                        </div>
                                        @if($annonce->images && count(json_decode($annonce->images)) > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $annonce->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $annonce->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        @endif
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title">{{ $annonce->titre_anno }}</h5>
                                        <p class="card-text">
                                            <strong>Prix:</strong> {{ $annonce->prix_anno }} €<br>
                                            <strong>Ville:</strong> {{ $annonce->ville_anno }}<br>
                                            <strong>Statut:</strong> 
                                            <span class="badge {{ $annonce->statut_anno === 'disponible' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $annonce->statut_anno }}
                                            </span>
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('proprietaire.modifierannonceproprietaire', $annonce->id) }}" class="btn btn-primary btn-sm">
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