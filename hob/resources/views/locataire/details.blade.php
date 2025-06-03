@extends('layouts.app')

@section('title', 'Détails du logement - FindStay')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{ $logement->type_log }} à {{ $logement->ville }}</h2>
                    
                    @if($logement->photos)
                        <div class="mb-4">
                            @php
                                $photos = json_decode($logement->photos, true);
                            @endphp
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($photos as $index => $photo)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset($photo) }}" class="d-block w-100" alt="Photo du logement" style="height: 400px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                                @if(count($photos) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h3>Détails du logement</h3>
                        <p><strong>Prix:</strong> {{ $logement->prix_log }} DH/mois</p>
                        <p><strong>Localisation:</strong> {{ $logement->localisation_log }}</p>
                        <p><strong>Type:</strong> {{ $logement->type_log }}</p>
                        <p><strong>Nombre de colocataires:</strong> {{ $logement->nombre_colocataire_log }}</p>
                        @if($logement->etage)
                            <p><strong>Étage:</strong> {{ $logement->etage }}</p>
                        @endif
                        @if($logement->equipements)
                            <p><strong>Équipements:</strong> {{ implode(', ', json_decode($logement->equipements, true)) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title mb-4">Propriétaire</h3>
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $proprietaire->photodeprofil_uti ? asset($proprietaire->photodeprofil_uti) : asset('images/default-avatar.png') }}" 
                             alt="{{ $proprietaire->prenom }}" 
                             class="rounded-circle me-3" 
                             style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <h5 class="mb-1">{{ $proprietaire->prenom }} {{ $proprietaire->nom_uti }}</h5>
                            <p class="text-muted mb-0">Propriétaire</p>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('conversations.show', $proprietaire->id) }}" class="btn btn-primary">
                            <i class="fas fa-envelope me-2"></i>Contacter le propriétaire
                        </a>
                        <a href="{{ route('showReservation', $logement->id) }}" class="btn btn-success">
                            <i class="fas fa-calendar-check me-2"></i>Réserver
                        </a>
                        <button class="btn btn-outline-primary toggle-favorite" data-listing-id="{{ $logement->id }}">
                            <i class="fas fa-heart me-2"></i>Ajouter aux favoris
                        </button>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4">Commentaires</h3>
                    
                    <!-- Comment Form -->
                    <form action="{{ route('storeComment', $logement->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <textarea name="comment" class="form-control" rows="3" placeholder="Écrivez votre commentaire..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Publier</button>
                    </form>

                    <!-- Comments List -->
                    <div class="comments-list">
                        @forelse($logement->comments as $comment)
                            <div class="comment mb-3 pb-3 border-bottom">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ $comment->user->photodeprofil_uti ? asset($comment->user->photodeprofil_uti) : asset('images/default-avatar.png') }}" 
                                         alt="{{ $comment->user->prenom }}" 
                                         class="rounded-circle me-2" 
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0">{{ $comment->user->prenom }} {{ $comment->user->nom_uti }}</h6>
                                        <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <p class="text-muted">Aucun commentaire pour le moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle favorite functionality
    const favoriteBtn = document.querySelector('.toggle-favorite');
    if (favoriteBtn) {
        favoriteBtn.addEventListener('click', function() {
            const listingId = this.dataset.listingId;
            fetch(`/locataire/favorite/${listingId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.classList.toggle('active');
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fas');
                    icon.classList.toggle('far');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});
</script>
@endpush

@endsection