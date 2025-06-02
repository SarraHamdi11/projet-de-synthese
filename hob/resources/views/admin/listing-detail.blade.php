
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de l'Annonce - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <!-- Header (Unchanged) -->
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

    <!-- Main Content (Redesigned with Animations) -->
    <main class="container mx-auto p-6 bg-gradient-to-b from-gray-100 to-gray-200">
        <h2 class="text-3xl font-bold text-blue-900 mb-8 animate-fade-in-down">Détail de l'Annonce #{{ $listing->id }}</h2>

        <!-- Listing Details Sections -->
        <div class="space-y-12">
            <!-- General Information -->
            <section class="animate-fade-in-up delay-100">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Informations Générales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Propriétaire</h4>
                        <p class="text-gray-700">{{ $listing->proprietaire->prenom ?? 'N/A' }} {{ $listing->proprietaire->nom_uti ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Titre</h4>
                        <p class="text-gray-700">{{ $listing->titre_anno }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Description</h4>
                        <p class="text-gray-700">{{ $listing->description_anno }}</p>
                    </div>
                </div>
            </section>

            <!-- Status and Dates -->
            <section class="animate-fade-in-up delay-200">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Statut et Dates</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Statut</h4>
                        <p class="text-gray-700">{{ $listing->statut_anno ?? 'Indisponible' }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Date de Publication</h4>
                        <p class="text-gray-700">{{ $listing->date_publication_anno ? $listing->date_publication_anno->format('d-m-Y') : 'N/A' }}</p>
                    </div>
                </div>
            </section>

            <!-- Pricing and Location -->
            <section class="animate-fade-in-up delay-300">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Tarification et Localisation</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Prix</h4>
                        <p class="text-gray-700">{{ $listing->logement->prix_log ?? 0 }}€</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Ville</h4>
                        <p class="text-gray-700">{{ $listing->logement->ville ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Étage</h4>
                        <p class="text-gray-700">{{ $listing->logement->etage ?? 'N/A' }}</p>
                    </div>
                </div>
            </section>

            <!-- Property Details -->
            <section class="animate-fade-in-up delay-400">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Détails du Logement</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Type</h4>
                        <p class="text-gray-700">{{ $listing->logement->type_log ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Nombre de Locataires</h4>
                        <p class="text-gray-700">{{ $listing->logement->nombre_colocataire_log ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Équipements</h4>
                        <p class="text-gray-700">{{ $listing->logement->equipements ? implode(', ', json_decode($listing->logement->equipements)) : 'Aucun' }}</p>
                    </div>
                </div>
            </section>

            <!-- Engagement Metrics -->
            <section class="animate-fade-in-up delay-500">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Engagement</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Note Moyenne</h4>
                        <p class="text-gray-700">{{ number_format($listing->average_note ?? 0, 1) }}/5</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Nombre de Commentaires</h4>
                        <p class="text-gray-700">{{ $listing->avis->count() ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Vues</h4>
                        <p class="text-gray-700">{{ $listing->logement->views ?? 0 }}</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Reviews Section -->
        <section class="mt-12 animate-fade-in-up delay-600">
            <button id="toggle-reviews-btn"
                class="bg-blue-900 hover:bg-blue-700 hover:scale-105 text-white px-6 py-3 text-lg rounded-full font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 animate-pulse-once relative group">
                Voir les Avis
                <span class="absolute left-0 bottom-0 w-0 h-[2px] bg-white transition-all duration-300 group-hover:w-full"></span>
            </button>

            <div id="reviews-table" class="hidden mt-6 bg-white p-8 rounded-xl shadow-lg transition-opacity duration-500 animate-fade-in-up delay-200">
                @if ($listing->avis->isNotEmpty())
                    <h3 class="text-xl font-semibold text-blue-900 mb-6">Avis des Locataires</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                            <thead>
                                <tr class="bg-blue-50">
                                    <th class="py-3 px-6 border-b text-left text-blue-900 font-semibold">Note</th>
                                    <th class="py-3 px-6 border-b text-left text-blue-900 font-semibold">Commentaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0; @endphp
                                @foreach ($listing->avis as $avis)
                                    <tr class="{{ $avis->note < 3 ? 'bg-red-50 text-red-700' : 'hover:bg-gray-100' }} animate-fade-in-up delay-{{ 250 + $index * 50 }}">
                                        <td class="py-3 px-6 border-b text-gray-700">{{ $avis->note ?? 0 }}/5</td>
                                        <td class="py-3 px-6 border-b text-gray-700">{{ $avis->contenu ?? 'Aucun commentaire' }}</td>
                                    </tr>
                                    @php $index++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-600 italic text-center">Aucun avis pour cette annonce.</p>
                @endif
            </div>
        </section>

        <!-- Back Button -->
        <div class="mt-8 animate-fade-in-up delay-700">
            <a href="{{ route('admin.listings') }}"
                class="bg-blue-900 hover:bg-blue-700 hover:scale-105 text-white px-6 py-3 text-lg rounded-full font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 animate-pulse-once relative group">
                Retour à la Liste des Annonces
                <span class="absolute left-0 bottom-0 w-0 h-[2px] bg-white transition-all duration-300 group-hover:w-full"></span>
            </a>
        </div>
    </main>

    <!-- Footer (Unchanged) -->
    <footer style="background-color: rgba(68, 120, 146, 0.45);" class="py-8 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-6 md:space-y-0">
                <!-- Section gauche - Logo et description -->
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-3">
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

    <!-- JavaScript for Reviews Toggle (Unchanged) -->
    <script>
        document.getElementById('toggle-reviews-btn').addEventListener('click', function() {
            const reviewsTable = document.getElementById('reviews-table');
            const isHidden = reviewsTable.classList.contains('hidden');

            if (isHidden) {
                reviewsTable.classList.remove('hidden');
                this.textContent = 'Masquer les Avis';
            } else {
                reviewsTable.classList.add('hidden');
                this.textContent = 'Voir les Avis';
            }
        });
    </script>

    <!-- Custom CSS for Animations -->
    <style>
        /* Fade-in-down animation */
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fade-in-down 0.8s ease-out forwards;
        }

        /* Fade-in-up animation */
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
        }

        /* Pulse-once animation for buttons */
        @keyframes pulse-once {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .animate-pulse-once {
            animation: pulse-once 1s ease-in-out;
        }

        /* Delay classes for staggered animations */
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-250 { animation-delay: 0.25s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-350 { animation-delay: 0.35s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }
        .delay-700 { animation-delay: 0.7s; }

        /* Ensure buttons and links have smooth transitions */
        button, a {
            position: relative;
            display: inline-block;
        }

        /* Improve focus states for accessibility */
        button:focus, a:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }
    </style>
</body>

</html>
