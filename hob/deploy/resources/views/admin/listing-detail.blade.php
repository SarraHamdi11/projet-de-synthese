<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de l'Annonce - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-slate-50 font-inter">
  

  <header class="relative h-80 bg-blue-100 px-10 py-0"
        style="background-image: url({{ asset('images/header_images.jpg') }}); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-white bg-opacity-50 z-0"></div>
        <div class="relative z-10 h-full px-5 py-2 flex flex-col justify-start">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-40">
                    <img src="{{ asset('images/findStay-removebg-preview.png') }}" alt="FindStay Logo"
                        style="height: 150px; width: auto;">
                    <nav class="flex space-x-40 text-xl font-bold text-blue-900">
                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ request()->routeIs('admin.dashboard') ? 'bg-white text-blue-900 shadow px-4 py-2 rounded-full' : 'hover:bg-white hover:text-blue-900 px-4 py-2 rounded-full transition duration-150' }}">
                            Statistiques
                        </a>
                        <a href="{{ route('admin.users') }}"
                            class="{{ request()->routeIs('admin.users') ? 'bg-white text-blue-900 shadow px-4 py-2 rounded-full' : 'hover:bg-white hover:text-blue-900 px-4 py-2 rounded-full transition duration-150' }}">
                            Gestion des Utilisateurs
                        </a>
                        <a href="{{ route('admin.listings') }}"
                            class="{{ request()->routeIs('admin.listings') ? 'bg-white text-blue-900 shadow px-4 py-2 rounded-full' : 'hover:bg-white hover:text-blue-900 px-4 py-2 rounded-full transition duration-150' }}">
                            Gestion des Annonces
                        </a>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('logout') }}"
                        class="bg-blue-900 hover:bg-blue-700 text-white px-5 py-2 text-lg rounded-full font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">
                        Déconnexion
                    </a>
                </div>
            </div>
            @php
                $hour = now()->hour;
                $greeting = $hour < 12 ? 'Bonjour' : ($hour < 18 ? 'Bon après-midi' : 'Bonsoir');
            @endphp
            <div class="text-blue-900 font-bold text-4xl pt-5 mb-4 font-sans">
                {{ $greeting }}, {{ Auth::user()->prenom }} {{ Auth::user()->nom_uti }}
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        <!-- Status Banner -->
        <div class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-r-lg modern-card">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <div>
                        <h3 class="text-green-800 font-semibold">Annonce {{ $listing->statut_anno ?? 'Indisponible' }}</h3>
                        <p class="text-green-600 text-sm">Publiée le {{ $listing->date_publication_anno ? $listing->date_publication_anno->format('d F Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 modern-card hover-lift stat-gradient-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-medium">Note Moyenne</p>
                        <p class="text-2xl font-bold text-white">{{ number_format($listing->average_note ?? 0, 1) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-star text-yellow-500 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 modern-card hover-lift stat-gradient-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-medium">Vues Totales</p>
                        <p class="text-2xl font-bold text-white">{{ $listing->logement->views ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-eye text-blue-500 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 modern-card hover-lift stat-gradient-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-medium">Commentaires</p>
                        <p class="text-2xl font-bold text-white">{{ $listing->avis->count() ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-comments text-purple-500 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 modern-card hover-lift stat-gradient-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-medium">Prix/mois</p>
                        <p class="text-2xl font-bold text-white">{{ $listing->logement->prix_log ?? 0 }}€</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-euro-sign text-green-500 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Property Information -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 modern-card">
                    <div class="p-6 border-b border-slate-200">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center">
                            <i class="fas fa-home text-blue-500 mr-3"></i>
                            Informations du Logement
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-slate-600">Titre de l'annonce</label>
                                    <p class="text-slate-900 font-medium">{{ $listing->titre_anno }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-600">Type de logement</label>
                                    <p class="text-slate-900">{{ $listing->logement->type_log ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-600">Ville</label>
                                    <p class="text-slate-900">{{ $listing->logement->ville ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-slate-600">Étage</label>
                                    <p class="text-slate-900">{{ $listing->logement->etage ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-600">Nombre de colocataires</label>
                                    <p class="text-slate-900">{{ $listing->logement->nombre_colocataire_log ?? 0 }} personnes</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-600">Équipements</label>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        @if($listing->logement->equipements)
                                            @foreach(json_decode($listing->logement->equipements) as $equipement)
                                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $equipement }}</span>
                                            @endforeach
                                        @else
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Aucun</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-6 border-t border-slate-200">
                            <label class="text-sm font-medium text-slate-600">Description</label>
                            <p class="text-slate-700 mt-2 leading-relaxed">{{ $listing->description_anno }}</p>
                        </div>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 modern-card">
                    <div class="p-6 border-b border-slate-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-slate-900 flex items-center">
                                <i class="fas fa-star text-yellow-500 mr-3"></i>
                                Avis des Locataires
                            </h2>
                            <button id="toggle-reviews" class="text-blue-500 hover:text-blue-600 font-medium interactive-element">
                                Voir tous les avis
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @if($listing->avis->isNotEmpty())
                                @php $visibleReviews = $listing->avis->take(2); @endphp
                                @foreach($visibleReviews as $avis)
                                    <div class="p-4 bg-slate-50 rounded-lg border-l-4 {{ $avis->note < 3 ? 'border-red-500' : 'border-green-500' }}">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <div class="flex text-yellow-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= $avis->note ? 'fas' : 'far' }} fa-star text-sm"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-sm text-slate-600">{{ $avis->note ?? 0 }}/5</span>
                                            </div>
                                            <span class="text-xs text-slate-500">{{ $avis->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-slate-700">{{ $avis->contenu ?? 'Aucun commentaire' }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-slate-600 italic">Aucun avis pour cette annonce.</p>
                            @endif
                        </div>
                        <div id="all-reviews" class="hidden mt-4 space-y-4">
                            @if($listing->avis->count() > 2)
                                @foreach($listing->avis->slice(2) as $avis)
                                    <div class="p-4 bg-slate-50 rounded-lg border-l-4 {{ $avis->note < 3 ? 'border-red-500' : 'border-orange-500' }}">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <div class="flex text-yellow-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= $avis->note ? 'fas' : 'far' }} fa-star text-sm"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-sm text-slate-600">{{ $avis->note ?? 0 }}/5</span>
                                            </div>
                                            <span class="text-xs text-slate-500">{{ $avis->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-slate-700">{{ $avis->contenu ?? 'Aucun commentaire' }}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div>
                    <a href="{{ route('admin.listings') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-all pulse-glow interactive-element">
                        Retour à la Liste des Annonces
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Owner Information -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 modern-card">
                    <div class="p-6 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900 flex items-center">
                            <i class="fas fa-user text-green-500 mr-3"></i>
                            Propriétaire
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-xl">
                                    {{ Str::upper(substr($listing->proprietaire->prenom ?? 'N', 0, 1) . substr($listing->proprietaire->nom_uti ?? 'A', 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-900">{{ $listing->proprietaire->prenom ?? 'N/A' }} {{ $listing->proprietaire->nom_uti ?? 'N/A' }}</h4>
                                <p class="text-slate-600 text-sm">Membre depuis {{ $listing->proprietaire->member_since }}</p>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= round($listing->proprietaire->average_note) ? 'fas' : 'far' }} fa-star text-xs"></i>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-slate-600 ml-2">{{ number_format($listing->proprietaire->average_note ?? 0, 1) }}/5</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-200">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Nombre d'annonces</span>
                                <span class="font-medium text-slate-900">{{ $listing->proprietaire->listings_count ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="mt-4 flex space-x-2">
                            <a href=""
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition-all pulse-glow interactive-element">
                                Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer HTML/PHP pour Laravel -->
    <footer style="background-color: rgba(68, 120, 146, 0.45);" class="py-8 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-6 md:space-y-0">

                <!-- Section gauche - Logo et description -->
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-3">
                        <!-- Icône maison SVG -->
                        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="text-xl font-semibold text-gray-700">FindStay</span>
                    </div>
                    <p class="text-gray-600 text-sm max-w-xs leading-relaxed">
                        Trouvez votre chez-vous avec FindStay. Facile, rapide, fiable
                    </p>
                </div>

                <!-- Section centre - Navigation admin -->
                <div class="flex-1 md:flex md:justify-center">
                    <div class="grid grid-cols-2 md:flex md:space-x-12 gap-6 md:gap-0">

                        <!-- Gestion des utilisateurs -->
                        <div class="text-center">
                            <a href="{{ route('admin.users') }}"
                                class="flex flex-col items-center space-y-2 text-gray-600 hover:text-gray-800 transition-colors group">
                                <!-- Icône utilisateurs SVG -->
                                <svg class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Gestion des utilisateurs</span>
                            </a>
                        </div>

                        <!-- Gestion des annonces -->
                        <div class="text-center">
                            <a href="{{ route('admin.listings') }}"
                                class="flex flex-col items-center space-y-2 text-gray-600 hover:text-gray-800 transition-colors group">
                                <!-- Icône documents SVG -->
                                <svg class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Gestion des annonces</span>
                            </a>
                        </div>

                        <!-- Statistiques -->
                        <div class="text-center col-span-2 md:col-span-1">
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex flex-col items-center space-y-2 text-gray-600 hover:text-gray-800 transition-colors group">
                                <!-- Icône graphique SVG -->
                                <svg class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">Statistiques</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Section droite - Contact -->
                <div class="flex-1 md:text-right">
                    <a href="mailto:FindStay@gmail.com"
                        class="text-gray-600 hover:text-gray-800 transition-colors text-sm font-medium">
                        FindStay@gmail.com
                    </a>
                </div>
            </div>

            <!-- Ligne de séparation -->
            <div class="border-t border-gray-400 mt-8 pt-4">
                <p class="text-center text-gray-600 text-sm">
                    © 2025 FindStay. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>



    <!-- JavaScript -->
    <script>
        // Toggle reviews
        document.getElementById('toggle-reviews').addEventListener('click', function() {
            const allReviews = document.getElementById('all-reviews');
            const isHidden = allReviews.classList.contains('hidden');

            if (isHidden) {
                allReviews.classList.remove('hidden');
                this.textContent = 'Masquer les avis';
            } else {
                allReviews.classList.add('hidden');
                this.textContent = 'Voir tous les avis';
            }
        });

        // Add smooth animations on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.modern-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Add click animations (ripple effect)
        document.querySelectorAll('.interactive-element').forEach(element => {
            element.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>

    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Smooth transitions */
        * {
            transition: all 0.2s ease;
        }

        /* Glass effect for header */
        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            backdrop-filter: blur(10px);
            z-index: -1;
        }

        /* Hover effects */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animated borders */
        .animated-border {
            position: relative;
            overflow: hidden;
        }

        .animated-border::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #3b82f6, transparent);
            transition: left 0.5s;
        }

        .animated-border:hover::before {
            left: 100%;
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Pulse effect for important elements */
        @keyframes pulse-glow {
            0%, 100% { 
                box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
            }
            50% { 
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.8), 0 0 30px rgba(59, 130, 246, 0.4);
            }
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        /* Modern card hover effects */
        .modern-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modern-card:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Gradient backgrounds for stats */
        .stat-gradient-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-gradient-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-gradient-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-gradient-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        /* Status indicators */
        .status-active::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: #10b981;
            border-radius: 2px;
        }

        /* Mobile responsiveness improvements */
        @media (max-width: 768px) {
            .mobile-hide {
                display: none;
            }

            .mobile-full {
                width: 100%;
            }

            .mobile-text-center {
                text-align: center;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .auto-dark {
                background-color: #1f2937;
                color: #f9fafb;
            }
        }

        /* Print styles */
        @media print {
            .no-print {
                display: none;
            }

            body {
                background: white;
                color: black;
            }
        }

        /* Accessibility improvements */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Focus indicators */
        button:focus,
        a:focus,
        input:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .bg-white {
                background-color: white;
                border: 2px solid black;
            }
        }
    </style>
</body>

</html>