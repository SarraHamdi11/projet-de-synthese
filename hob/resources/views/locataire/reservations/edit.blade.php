@extends('layouts.app')

@section('title', 'Modifier Réservation')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h2 class="h2 fw-bold mb-4 text-dark text-center">Modifier votre Réservation</h2>
                
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4 p-md-5">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Erreurs de validation :</strong>
                                </div>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('locataire.reservations.update', $reservation->id) }}">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-4">
                                <label for="nombre_colocataire_log" class="form-label fw-medium text-dark">
                                    <i class="fas fa-users me-2 text-primary"></i>
                                    Nombre de colocataires
                                </label>
                                <input type="number" 
                                       id="nombre_colocataire_log" 
                                       name="nombre_colocataire_log" 
                                       value="{{ old('nombre_colocataire_log', $reservation->logements->nombre_colocataire_log) }}" 
                                       min="1" 
                                       class="form-control form-control-lg border-2 @error('nombre_colocataire_log') is-invalid @enderror" 
                                       required />
                                @error('nombre_colocataire_log')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="date_debut_res" class="form-label fw-medium text-dark">
                                    <i class="fas fa-calendar-alt me-2 text-success"></i>
                                    Date de début
                                </label>
                                <input type="date" 
                                       id="date_debut_res" 
                                       name="date_debut_res" 
                                       value="{{ old('date_debut_res', $reservation->date_debut_res->format('Y-m-d')) }}" 
                                       class="form-control form-control-lg border-2 @error('date_debut_res') is-invalid @enderror" 
                                       required />
                                @error('date_debut_res')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="date_fin_res" class="form-label fw-medium text-dark">
                                    <i class="fas fa-calendar-check me-2 text-warning"></i>
                                    Date de fin
                                </label>
                                <input type="date" 
                                       id="date_fin_res" 
                                       name="date_fin_res" 
                                       value="{{ old('date_fin_res', $reservation->date_fin_res->format('Y-m-d')) }}" 
                                       class="form-control form-control-lg border-2 @error('date_fin_res') is-invalid @enderror" 
                                       required />
                                @error('date_fin_res')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-end mt-5">
                                <a href="{{ route('locataire.reservations.index') }}" 
                                   class="btn btn-outline-secondary btn-lg px-4 order-2 order-sm-1">
                                    <i class="fas fa-times me-2"></i>
                                    Annuler
                                </a>
                                <button type="submit" 
                                        class="btn btn-primary btn-lg px-4 order-1 order-sm-2">
                                    <i class="fas fa-save me-2"></i>
                                    Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Informations sur la réservation -->
                <div class="card mt-4 border-0 bg-light">
                    <div class="card-body p-4">
                        <h6 class="card-title fw-bold text-muted mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Informations sur la réservation
                        </h6>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-home text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Logement</small>
                                        <span class="fw-medium">{{ $reservation->logements->annonces->first()->titre_anno ?? $reservation->logements->type_log ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Ville</small>
                                        <span class="fw-medium">{{ $reservation->logements->ville ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user text-info me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Propriétaire</small>
                                        <span class="fw-medium">{{ $reservation->proprietaire->prenom ?? 'N/A' }} {{ $reservation->proprietaire->nom_uti ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock text-warning me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Demande créée le</small>
                                        <span class="fw-medium">{{ $reservation->created_at->format('d/m/Y à H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .card {
            transition: all 0.3s ease;
        }
        
        .btn {
            transition: all 0.2s ease;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        .form-control {
            transition: all 0.2s ease;
        }
        
        .form-control:hover {
            border-color: #0d6efd;
        }
        
        .alert {
            border: none;
            border-left: 4px solid #dc3545;
        }
        
        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem !important;
            }
            
            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateDebutInput = document.getElementById('date_debut_res');
            const dateFinInput = document.getElementById('date_fin_res');
            
            // Définir la date minimum à aujourd'hui
            const today = new Date().toISOString().split('T')[0];
            dateDebutInput.min = today;
            
            // Mettre à jour la date minimum de fin quand la date de début change
            dateDebutInput.addEventListener('change', function() {
                dateFinInput.min = this.value;
                if (dateFinInput.value && dateFinInput.value < this.value) {
                    dateFinInput.value = '';
                }
            });
            
            // Validation en temps réel
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required]');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
                
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });
        });
    </script>
@endsection