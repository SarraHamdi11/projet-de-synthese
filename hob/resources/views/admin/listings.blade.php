<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Annonces - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <!-- Header (unchanged) -->
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
    <main class="container mx-auto p-6">
        <!-- Filters and Search -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Gestion des Annonces </h2>
            <div class="flex space-x-2 items-center">
                <!-- Filter Form -->
                <form action="{{ route('admin.listings') }}" method="GET" class="flex space-x-2">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Rechercher par nom, titre..." class="border rounded p-2 w-64"
                        onchange="this.form.submit()">
                    <select name="type" class="border rounded p-2" onchange="this.form.submit()">
                        <option value="">Tous les types</option>
                        <option value="studio" {{ $type == 'studio' ? 'selected' : '' }}>Studio</option>
                        <option value="appartement" {{ $type == 'appartement' ? 'selected' : '' }}>Appartement</option>
                        <option value="maison" {{ $type == 'maison' ? 'selected' : '' }}>Maison</option>
                    </select>
                    <select name="status" class="border rounded p-2" onchange="this.form.submit()">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Disponible</option>
                        <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Indisponible</option>
                    </select>
                    <select name="ville" class="border rounded p-2" onchange="this.form.submit()">
                        <option value="">Toutes les villes</option>
                        <option value="Lyon" {{ $ville == 'Lyon' ? 'selected' : '' }}>Lyon</option>
                        <option value="Paris" {{ $ville == 'Paris' ? 'selected' : '' }}>Paris</option>
                        <option value="Tanger" {{ $ville == 'Tanger' ? 'selected' : '' }}>Tanger</option>
                        <option value="Tetouan" {{ $ville == 'Tetouan' ? 'selected' : '' }}>Tetouan</option>
                        <option value="Casablanca" {{ $ville == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
                        <option value="Rabat" {{ $ville == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                        <option value="Fes" {{ $ville == 'Fes' ? 'selected' : '' }}>Fes</option>
                        <option value="Marrakech" {{ $ville == 'Marrakech' ? 'selected' : '' }}>Marrakech</option>
                        <option value="Agadir" {{ $ville == 'Agadir' ? 'selected' : '' }}>Agadir</option>
                        <option value="Oujda" {{ $ville == 'Oujda' ? 'selected' : '' }}>Oujda</option>
                        <option value="Meknes" {{ $ville == 'Meknes' ? 'selected' : '' }}>Meknes</option>
                        <option value="Essaouira" {{ $ville == 'Essaouira' ? 'selected' : '' }}>Essaouira</option>

                        <!-- Add more cities dynamically if needed -->
                    </select>
                    <input type="date" name="date" value="{{ $date }}" class="border rounded p-2"
                        onchange="this.form.submit()">
                </form>

                <!-- Export Button -->
                <a href="{{ route('admin.exportListings') }}"
                    class="bg-blue-900 hover:bg-blue-700 text-white px-5 py-2 text-lg rounded-full font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">Exporter</a>

                <!-- Sort Buttons (Arrow Icons) -->
                <div class="flex space-x-2">
                    <a href="{{ route('admin.listings') }}?sort_by_note=asc&search={{ $search }}&type={{ $type }}&status={{ $status }}&ville={{ $ville }}&date={{ $date }}"
                        class="px-3 py-2 rounded {{ $sort == 'asc' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                        title="Trier par note (croissant)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7">
                            </path>
                        </svg>
                    </a>
                    <a href="{{ route('admin.listings') }}?sort_by_note=desc&search={{ $search }}&type={{ $type }}&status={{ $status }}&ville={{ $ville }}&date={{ $date }}"
                        class="px-3 py-2 rounded {{ $sort == 'desc' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                        title="Trier par note (décroissant)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Listings Table -->
        <div class="bg-white p-4 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Propriétaire</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            de Publication</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ville</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre Locataire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Note
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($listings as $listing)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span>{{ $listing->proprietaire ? $listing->proprietaire->prenom . ' ' . $listing->proprietaire->nom_uti : 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->titre_anno }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->statut_anno ?? 'Indisponible' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $listing->date_publication_anno ? $listing->date_publication_anno->format('d-m-Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->logement->prix_log ?? 0 }}MAD</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->logement->ville ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->logement->type_log ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->nombre_locataire }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($listing->average_note, 1) }}/5
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.showListingDetail', $listing->id) }}"
                                    class="text-blue-600 hover:underline mr-2">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                    </svg>

                                </a>
                                <form action="{{ route('admin.deleteListing', $listing->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                        </svg>

                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-4 text-center text-gray-500">Aucune annonce trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $listings->links() }}
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
</body>

</html>
