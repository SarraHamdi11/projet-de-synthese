<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
    .login-container {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: #335c81;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #274a67;
    }

    .stat-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-card h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .stat-card p.text-2xl {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .stat-card .change {
        font-size: 0.875rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .stat-card .change.up {
        color: #10b981;
    }

    .stat-card .change.down {
        color: #ef4444;
    }

    .stat-card .change .arrow {
        margin-left: 0.25rem;
        font-size: 0.75rem;
    }
</style>

<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <header class="relative h-80 bg-blue-100 px-10 py-0"
        style="background-image: url({{ asset('images/header_images.jpg') }}); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-white bg-opacity-50 z-0"></div>

        <!-- Contenu principal -->
        <div class="relative z-10 h-full px-5 py-2 flex flex-col justify-start">

            <!-- Barre de navigation -->
            <div class="flex justify-between items-center mb-8">
                <!-- Logo + liens -->
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

                <!-- Déconnexion -->
                <div>
                    <a href="{{ route('logout') }}"
                        class="bg-blue-900 hover:bg-blue-700 text-white px-5 py-2 text-lg rounded-full font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">
                        Déconnexion
                    </a>
                </div>
            </div>

            <!-- Greeting below navigation -->
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

        <!-- Filters -->
       <div class="flex justify-end items-center mb-6">
    <form id="filterForm" action="{{ route('admin.dashboard') }}" method="GET" class="flex space-x-4">
        <div>
            <label for="year" class="block text-sm font-medium text-gray-700">Année</label>
            <select name="year" id="year" class="border rounded p-2">
                @php
                    $currentYear = isset($year) && $year ? $year : date('Y');
                @endphp
                @for ($y = 2025; $y >= 2017; $y--)
                    <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label for="month" class="block text-sm font-medium text-gray-700">Mois</label>
            <select name="month" id="month" class="border rounded p-2">
                <option value="" {{ !isset($month) || $month == '' ? 'selected' : '' }}>Tous</option>
                @foreach (['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'] as $m)
                    <option value="{{ $m }}" {{ isset($month) && $month == $m ? 'selected' : '' }}>
                        {{ $m }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit"
            class="bg-blue-900 hover:bg-blue-700 text-white px-5 py-2 text-lg rounded-full font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">
            Mettre à jour
        </button>
    </form>
</div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-5 gap-4 mb-6">
            <div class="stat-card">
                <h3 class="text-lg font-semibold">Total Utilisateurs</h3>
                <p class="text-2xl">{{ $totalUsers }}</p>
                <div class="change {{ $usersPercentageChange >= 0 ? 'up' : 'down' }}">
                    {{ number_format(abs($usersPercentageChange), 1) }}%
                    <span class="arrow">{{ $usersPercentageChange >= 0 ? '↑' : '↓' }}</span>
                </div>
            </div>
            <div class="stat-card">
                <h3 class="text-lg font-semibold">Total Annonces</h3>
                <p class="text-2xl">{{ $totalListings }}</p>
                <div class="change {{ $listingsPercentageChange >= 0 ? 'up' : 'down' }}">
                    {{ number_format(abs($listingsPercentageChange), 1) }}%
                    <span class="arrow">{{ $listingsPercentageChange >= 0 ? '↑' : '↓' }}</span>
                </div>
            </div>
            <div class="stat-card">
                <h3 class="text-lg font-semibold">Total Réservations</h3>
                <p class="text-2xl">{{ $totalReservations }}</p>
                <div class="change {{ $reservationsPercentageChange >= 0 ? 'up' : 'down' }}">
                    {{ number_format(abs($reservationsPercentageChange), 1) }}%
                    <span class="arrow">{{ $reservationsPercentageChange >= 0 ? '↑' : '↓' }}</span>
                </div>
            </div>
            <div class="stat-card">
                <h3 class="text-lg font-semibold">Total Réservations Acceptées</h3>
                <p class="text-2xl">{{ $totalAcceptedReservations }}</p>
                <div class="change {{ $acceptedPercentageChange >= 0 ? 'up' : 'down' }}">
                    {{ number_format(abs($acceptedPercentageChange), 1) }}%
                    <span class="arrow">{{ $acceptedPercentageChange >= 0 ? '↑' : '↓' }}</span>
                </div>
            </div>
            <div class="stat-card">
                <h3 class="text-lg font-semibold">Total Réservations Annulées</h3>
                <p class="text-2xl">{{ $totalRefusedReservations }}</p>
                <div class="change {{ $refusedPercentageChange >= 0 ? 'up' : 'down' }}">
                    {{ number_format(abs($refusedPercentageChange), 1) }}%
                    <span class="arrow">{{ $refusedPercentageChange >= 0 ? '↑' : '↓' }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Évolution des inscriptions</h3>
                <canvas id="newUsersChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Évolution des annonces</h3>
                <canvas id="newListingsChart"></canvas>
            </div>
        </div>

        <!-- Side Panels -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Derniers utilisateurs inscrits</h3>
                @forelse($recentUsers->where('role_uti', '!=', 'admin') as $user)
                    <div class="flex items-center mb-2">
                        <!-- User icon with color based on role -->
                        <svg class="w-10 h-10 mr-2 {{ $user->role_uti == 'locataire' ? 'text-blue-500' : ($user->role_uti == 'colocataire' ? 'text-green-500' : 'text-purple-500') }}"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                        </svg>
                        <span>{{ $user->prenom }} {{ $user->nom_uti }}</span>
                    </div>
                @empty
                    <p class="text-gray-500">Aucun utilisateur récent (hors admin).</p>
                @endforelse
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Dernières annonces publiées</h3>
                @forelse($recentListings as $listing)
                    <div class="flex items-center mb-2">
                        <!-- Listing icon -->
                        <svg class="w-10 h-10 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6zm2 2v2h2V6H8zm4 0v2h2V6h-2zm-2 4v2h2v-2H8zm4 0v2h2v-2h-2z" />
                        </svg>
                        <div>
                            <p class="font-medium">{{ $listing->titre_anno }}</p>
                            <p class="text-sm text-gray-600">{{ Str::limit($listing->description_anno, 50) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Aucune annonce récente.</p>
                @endforelse
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Top 4 Villes</h3>
                <canvas id="topCitiesChart"></canvas>
            </div>
        </div>

        <script>
            const newUsersByMonth = <?php echo json_encode($newUsersByMonth); ?>;
            const newListingsByMonth = <?php echo json_encode($newListingsByMonth); ?>;
            const topCities = <?php echo json_encode($topCities); ?>;
            const topCitiesCounts = <?php echo json_encode($topCitiesCounts); ?>;

            const newUsersCtx = document.getElementById('newUsersChart').getContext('2d');
            new Chart(newUsersCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Nouvelles inscriptions',
                        data: newUsersByMonth,
                        borderColor: '#1E3A8A',
                        fill: false,
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            const newListingsCtx = document.getElementById('newListingsChart').getContext('2d');
            new Chart(newListingsCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Nouvelles annonces',
                        data: newListingsByMonth,
                        borderColor: '#1E3A8A',
                        fill: false,
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            const topCitiesCtx = document.getElementById('topCitiesChart').getContext('2d');
            new Chart(topCitiesCtx, {
                type: 'doughnut',
                data: {
                    labels: topCities,
                    datasets: [{
                        label: 'Top 4 Villes',
                        data: topCitiesCounts,
                        backgroundColor: ['#1E3A8A', '#3B82F6', '#93C5FD', '#D1D5DB'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        </script>
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
