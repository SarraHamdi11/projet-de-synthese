@extends('layouts.app')

@section('title', 'Mes Réservations')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <div class="container">
        <h2 class="fs-3 fw-bold mb-4 text-dark">Vos Réservations</h2>

        <!-- Statistiques -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-5 mb-5">
            <div class="col">
                <div class="bg-white rounded-3 shadow p-4 border-start border-5 border-primary">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                style="width: 2.5rem; height: 2.5rem;">
                                <svg class="text-primary" width="18" height="18" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <dl>
                                <dt class="small fw-medium text-muted truncate">Total des réservations</dt>
                                <dd class="fs-5 fw-semibold text-dark">{{ $totalReservations }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="bg-white rounded-3 shadow p-4 border-start border-5 border-success">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center"
                                style="width: 2.5rem; height: 2.5rem;">
                                <svg class="text-success" width="18" height="18" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <dl>
                                <dt class="small fw-medium text-muted truncate">Réservations acceptées</dt>
                                <dd class="fs-5 fw-semibold text-dark">{{ $acceptees }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="bg-white rounded-3 shadow p-4 border-start border-5 border-danger">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center"
                                style="width: 2.5rem; height: 2.5rem;">
                                <svg class="text-danger" width="18" height="18" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <dl>
                                <dt class="small fw-medium text-muted truncate">Réservations annulées</dt>
                                <dd class="fs-5 fw-semibold text-dark">{{ $annulees }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="bg-white rounded-3 shadow p-4 border-start border-5 border-purple">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-purple-subtle d-flex align-items-center justify-content-center"
                                style="width: 2.5rem; height: 2.5rem;">
                                <svg class="text-purple" width="18" height="18" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <dl>
                                <dt class="small fw-medium text-muted truncate">Réservations terminées</dt>
                                <dd class="fs-5 fw-semibold text-dark">{{ $terminees }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section de filtrage -->
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <form method="GET" action="{{ route('locataire.reservations.index') }}" id="filterForm">
                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button"
                                class="btn filter-btn {{ $statut == 'en_attente' ? 'active bg-primary text-white' : 'border-primary text-primary bg-transparent' }}"
                                data-filter="en_attente">
                                En attente ({{ $enAttente }})
                            </button>
                            <button type="button"
                                class="btn filter-btn {{ $statut == 'acceptee' ? 'active bg-success text-white' : 'border-success text-success bg-transparent' }}"
                                data-filter="acceptee">
                                Acceptées ({{ $acceptees }})
                            </button>
                            <button type="button"
                                class="btn filter-btn {{ $statut == 'annulee' ? 'active bg-danger text-white' : 'border-danger text-danger bg-transparent' }}"
                                data-filter="annulee">
                                Annulées ({{ $annulees }})
                            </button>
                            <button id="btn-historique" type="button"
                                class="btn filter-btn border-purple text-purple bg-transparent" data-filter="historique">
                                Terminées
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="statut" id="statutFilter" value="{{ $statut }}">
                </form>
            </div>
        </div>

        <!-- Liste des réservations -->
        <div class="card shadow-sm">
            @forelse ($reservations as $reservation)
                <div class="card-body border-bottom {{ !$loop->last ? '' : 'border-0' }} position-relative">
                    <div class="row align-items-center mb-3">
                        <!-- En-tête avec statut -->
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <span
                                class="badge fs-6 {{ $reservation->statut_res === 'en_attente' ? 'bg-primary' : ($reservation->statut_res === 'acceptee' ? 'bg-success' : ($reservation->statut_res === 'annulee' ? 'bg-danger' : 'bg-purple')) }}">
                                @if ($reservation->statut_res === 'en_attente')
                                    En attente
                                @elseif($reservation->statut_res === 'acceptee')
                                    Acceptée
                                @elseif($reservation->statut_res === 'annulee')
                                    Annulée
                                @else
                                    Terminée
                                @endif
                            </span>
                        </div>
                        <!-- Actions -->
                        <div class="col-12 col-md-6">
                            <div class="d-flex gap-2 justify-content-md-end">
                                @if ($reservation->statut_res === 'en_attente')
                                    <a href="{{ route('locataire.reservations.edit', $reservation->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i> Modifier
                                    </a>
                                    <form method="POST"
                                        action="{{ route('locataire.reservations.annuler', $reservation->id) }}"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                            <i class="fas fa-times me-1"></i> Annuler
                                        </button>
                                    </form>
                                @endif
                                @if ($reservation->logements->annonces->first())
                                    <a href="{{ route('locataire.reservations.show', $reservation->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i> Détails
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contenu principal en colonnes -->
                    <div class="row g-4">
                        <!-- Colonne 1: Informations du logement -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <h6 class="text-muted text-uppercase fw-bold border-bottom pb-2 mb-3 small">Logement</h6>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-home text-muted me-2"></i>
                                <span
                                    class="fw-medium small">{{ $reservation->logements->annonces->first()->titre_anno ?? ($reservation->logements->type_log ?? 'Logement') }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                <span
                                    class="text-muted small">{{ $reservation->logements->ville ?? 'Ville non spécifiée' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users text-muted me-2"></i>
                                <span class="text-muted small">{{ $reservation->logements->nombre_colocataire_log ?? 0 }}
                                    {{ ($reservation->logements->nombre_colocataire_log ?? 0) <= 1 ? 'colocataire' : 'colocataires' }}</span>
                            </div>
                        </div>

                        <!-- Colonne 2: Propriétaire -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <h6 class="text-muted text-uppercase fw-bold border-bottom pb-2 mb-3 small">Propriétaire</h6>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-user text-muted me-2"></i>
                                <span class="fw-medium small">{{ $reservation->proprietaire->prenom ?? 'N/A' }}
                                    {{ $reservation->proprietaire->nom_uti ?? '' }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-envelope text-muted me-2"></i>
                                <span class="text-muted small">{{ $reservation->proprietaire->email_uti ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-phone text-muted me-2"></i>
                                <a href="tel:{{ $reservation->proprietaire->tel_uti ?? '' }}"
                                    class="text-primary text-decoration-none small hover-text-primary-dark">{{ $reservation->proprietaire->tel_uti ?? 'Non enregistrée' }}</a>
                            </div>
                        </div>

                        <!-- Colonne 3: Dates et durée -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <h6 class="text-muted text-uppercase fw-bold border-bottom pb-2 mb-3 small">Dates</h6>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar text-muted me-2"></i>
                                <span class="text-muted small">Demande:
                                    {{ $reservation->created_at->format('d/m/Y') }}</span>
                            </div>
                            @if ($reservation->date_debut_res && $reservation->date_fin_res)
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock text-muted me-2"></i>
                                    <span
                                        class="fw-medium small text-dark">{{ \Carbon\Carbon::parse($reservation->date_debut_res)->format('d/m/Y') }}</span>
                                    <span class="text-muted mx-2">→</span>
                                    <span
                                        class="fw-medium small text-dark">{{ \Carbon\Carbon::parse($reservation->date_fin_res)->format('d/m/Y') }}</span>
                                </div>
                            @endif
                            @if ($reservation->statut_res === 'terminee' && $reservation->duration)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-hourglass-end text-muted me-2"></i>
                                    <span class="text-success fw-medium small">{{ $reservation->duration }}
                                        jour{{ $reservation->duration > 1 ? 's' : '' }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Colonne 4: Statut et informations -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <h6 class="text-muted text-uppercase fw-bold border-bottom pb-2 mb-3 small">Statut</h6>
                            @if ($reservation->statut_res === 'acceptee' && $reservation->remaining_days !== null)
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock text-muted me-2"></i>
                                    @if ($reservation->remaining_days > 0)
                                        <span class="text-warning fw-medium small">{{ $reservation->remaining_days }}
                                            jour{{ $reservation->remaining_days > 1 ? 's' : '' }}
                                            restant{{ $reservation->remaining_days > 1 ? 's' : '' }}</span>
                                    @else
                                        <span class="text-danger fw-medium small">Période expirée</span>
                                    @endif
                                </div>
                            @endif
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-2 {{ $reservation->statut_res === 'en_attente' ? 'bg-primary' : ($reservation->statut_res === 'acceptee' ? 'bg-success' : ($reservation->statut_res === 'annulee' ? 'bg-danger' : 'bg-purple')) }}"
                                    style="width: 8px; height: 8px;"></div>
                                <span class="text-muted small">{{ $reservation->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card-body text-center py-6">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="fs-5 fw-semibold text-dark mb-2">Aucune réservation trouvée</h5>
                    <p class="text-muted small mb-0">Vos demandes de réservation apparaîtront ici selon vos filtres.</p>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .bg-purple {
            background-color: #6f42c1;
        }

        .bg-purple-subtle {
            background-color: #e5d8f5;
        }

        .text-purple {
            color: #6f42c1;
        }

        .border-purple {
            border-color: #6f42c1;
        }

        .hover-text-primary-dark:hover {
            color: #0d6efd;
        }

        .filter-btn {
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border-width: 2px;
        }

        .filter-btn.active {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card {
            transition: all 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            transition: background-color 0.2s ease;
        }

        .card-body:hover {
            background-color: #f8f9fa;
        }

        .badge {
            padding: 0.5em 0.8em;
        }

        @media (max-width: 768px) {
            .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const statutFilter = document.getElementById('statutFilter');
            const filterForm = document.getElementById('filterForm');
            const btn = document.getElementById('btn-historique');

            btn.addEventListener('click', () => {
                btn.classList.add('active', 'text-white', 'bg-purple');
                btn.classList.remove('border-purple', 'text-purple', 'bg-transparent');
            });
            filterButtons.forEach(button => {
                button.addEventListener('click', funFction() {
                    // Reset all buttons
                    filterButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-primary', 'bg-success',
                            'bg-danger', 'bg-purple', 'text-white');
                        const filter = btn.dataset.filter;
                        btn.classList.add('bg-transparent',
                            `border-${filter === 'historique' ? 'purple' : filter}`,
                            `text-${filter === 'historique' ? 'purple' : filter}`);
                    });

                    // Activate clicked button
                    const filter = this.dataset.filter;
                    this.classList.add('active',
                        `bg-${filter === 'historique' ? 'purple' : filter}`, 'text-white');
                    this.classList.remove(`border-${filter === 'historique' ? 'purple' : filter}`,
                        `text-${filter === 'historique' ? 'purple' : filter}`, 'bg-transparent');

                    statutFilter.value = filter;
                    filterForm.submit();
                });
            });
        });
    </script>
@endsection
