<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        .login-container {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #335c81;
            transition: background-color 0.3s;
        }

        .footer_color {
            background-color: #84b2d1;
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

        .stat-card h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            font-size: 1rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }

        .quote-icon {
            font-size: 2rem;
            color: #1D2D44;
            line-height: 1;
        }

        .city-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            text-align: center;
            transition: transform 0.2s;
        }

        .city-card:hover {
            transform: translateY(-5px);
        }

        /* Animations and Transitions */
        .animate-fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        .animate-slide-down {
            animation: slideDown 1s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 1s ease-out;
        }

        .animate-pulse-once {
            animation: pulseOnce 1.5s ease-out;
        }

        .animate-bounce {
            animation: bounce 1s infinite;
        }

        .animate-bounce-slow {
            animation: bounce 2s infinite;
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        .transition-height {
            transition: max-height 0.3s ease-in-out;
        }

        .faq-answer[data-expanded="true"] {
            max-height: 200px;
            /* Adjust based on content height */
        }

        .city-card,
        .bg-white {
            transition: all 0.3s ease;
        }

        .hover\:translate-y-2 {
            transition: transform 0.3s ease;
        }

        .hover\:translate-y-3 {
            transition: transform 0.5s ease;
        }

        .hover\:rotate-1 {
            transition: transform 0.5s ease;
        }

        .hover\:bg-blue-50 {
            transition: background-color 0.3s ease;
        }

        .hover\:bg-gray-50 {
            transition: background-color 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulseOnce {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <header class="relative h-80 bg-blue-100 px-10 py-0" style="background-image: url({{ asset('images/header_images.jpg') }}); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-white bg-opacity-50 z-0"></div>
        <div class="relative z-10 h-full px-5 py-2 flex flex-col justify-start">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-40">
                    <img src="{{ asset('images/findStay-removebg-preview.png') }}" alt="FindStay Logo"
                        style="height: 150px; width: auto;">
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('login') }}"
                        class="bg-blue-900 hover:bg-blue-700 text-white px-5 py-2 text-lg rounded-full font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">
                        Connexion
                    </a>
                    <a href="{{ route('signup') }}"
                        class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 text-lg rounded-full font-semibold focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition">
                        Inscription
                    </a>
                </div>
            </div>
            <div class="text-blue-900 font-bold text-4xl pt-5 mb-4 font-sans">
                Votre Propriété, Notre Propriété
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mx-auto">
        <!-- New Section: Cities with Available Logements -->
        <section class="container mx-auto py-6">
            <h2 class="text-xl md:text-2xl font-semibold text-blue-900 mb-4 text-center animate-fade-in">Trouver des
                logements dans ces villes</h2>
            @if (isset($cityLogements) && $cityLogements->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach ($cityLogements as $item)
                        <div
                            class="city-card bg-white rounded-lg p-4 shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 transform hover:bg-blue-50">
                            <h3 class="font-semibold text-lg text-blue-900 text-center">{{ $item->ville }}</h3>
                            <p class="text-gray-600 text-center">{{ $item->logement_count }}
                                logement{{ $item->logement_count > 1 ? 's' : '' }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}"
                        class="text-blue-900 hover:text-blue-700 font-semibold inline-block animate-bounce">Voir plus
                        →</a>
                </div>
            @else
                <p class="text-center text-gray-600 animate-pulse">Aucune ville avec des logements disponibles pour le
                    moment.</p>
            @endif
        </section>

        <!-- Les dernières logements ajoutés -->
        <section class="mx-auto mb-16 p-6">
            <h2 class="text-xl md:text-2xl font-semibold text-blue-900 mb-4 text-center animate-fade-in">Les dernières
                logements ajoutés</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($latestLogements as $logement)
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl hover:-translate-y-3 transition-all duration-500 transform hover:rotate-1">
                        <img src="{{ !empty($logement->photos) ? asset('images/' . (is_array($logement->photos) ? $logement->photos[0] : json_decode($logement->photos, true)[0])) : asset('images/placeholder.jpg') }}"
                            alt="{{ $logement->type_log }} à {{ $logement->ville }}"
                            class="w-full h-48 object-cover transition-opacity duration-300 hover:opacity-90">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2 animate-pulse-once">
                                {{ ucfirst($logement->type_log) }}</h3>
                            <p class="text-green-600 font-bold animate-fade-in">
                                {{ number_format($logement->prix_log, 0) }} DH / MOIS</p>
                            <p class="text-sm text-gray-500">{{ $logement->ville }}</p>
                            <div class="mt-2 flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $logement->average_note)
                                        <span
                                            class="text-yellow-400 hover:text-yellow-500 transition-colors duration-200">★</span>
                                    @else
                                        <span
                                            class="text-gray-300 hover:text-gray-400 transition-colors duration-200">☆</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-600 animate-bounce">Aucun logement récent disponible pour le moment.
                    </p>
                @endforelse
            </div>
        </section>

        <!-- FAQ Section (Dynamic Reviews) -->
        <section id="faq-section" class="mx-auto mb-16 p-6">
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-blue-900 mb-4 text-center animate-slide-up">FAQ ?</h2>
                <p class="faq-question font-semibold text-lg text-gray-600 mb-6 text-center animate-fade-in "
                    onclick="toggleAnswer(this)">Ce que nos clients nous disent ?</p>
                <div class="faq-answer grid grid-cols-1 md:grid-cols-3 gap-6" data-expanded="false">
                    @forelse ($avis as $item)
                        <div
                            class="bg-white rounded-lg p-6 shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-400 transform hover:bg-gray-50">
                            <div class="flex items-center mb-4">
                                <p class="font-bold text-lg text-blue-900 animate-pulse-once">{{ $item->nom_prenom }}
                                </p>
                                <span class="quote-icon ml-2 animate-bounce-slow">"</span>
                            </div>
                            <p class="text-gray-600 transition-opacity duration-300 hover:opacity-90">
                                {{ $item->contenu }}</p>
                            <div class="flex items-center mt-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $item->note)
                                        <span
                                            class="text-yellow-400 hover:text-yellow-500 transition-colors duration-200">★</span>
                                    @else
                                        <span
                                            class="text-gray-300 hover:text-gray-400 transition-colors duration-200">☆</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-600 animate-pulse">Aucun avis disponible pour le moment.</p>
                    @endforelse
                </div>
            </div>


            <div class="text-center space-y-4">
                <div class="faq-item">
                    <p class="faq-question font-semibold mb-2 cursor-pointer text-gray-800 hover:text-blue-600 animate-fade-in"
                        onclick="toggleAnswer(this)">Qu'est-ce que FindStay ?</p>
                    <p class="faq-answer text-gray-600 mb-4 mx-auto max-w-2xl transition-height duration-300"
                        style="overflow: hidden; max-height: 0;" data-expanded="false">
                        FindStay est une plateforme innovante conçue pour simplifier la recherche et la réservation
                        d'hébergements de qualité à travers le monde. Que vous planifiez des vacances, un voyage
                        d'affaires ou une escapade de dernière minute, FindStay vous connecte à une vaste sélection de
                        logements, allant des hôtels de luxe aux appartements cosy, en passant par des maisons d'hôtes
                        uniques. Grâce à une interface intuitive, des filtres avancés (comme le prix, la localisation,
                        ou les commodités), et des avis authentiques de voyageurs, FindStay garantit une expérience
                        personnalisée et fiable. Notre mission est de rendre chaque séjour mémorable en vous offrant des
                        options adaptées à vos besoins et à votre budget.
                    </p>
                </div>
                <div class="faq-item">
                    <p class="faq-question font-semibold mb-2 cursor-pointer text-gray-800 hover:text-blue-600 animate-fade-in"
                        onclick="toggleAnswer(this)">Comment créer un compte sur FindStay ?</p>
                    <p class="faq-answer text-gray-600 mb-4 mx-auto max-w-2xl transition-height duration-300"
                        style="overflow: hidden; max-height: 0;" data-expanded="false">
                        Créer un compte sur FindStay est simple et rapide. Cliquez sur le bouton "S'inscrire" situé en
                        haut à droite de notre site web ou application mobile. Remplissez le formulaire avec vos
                        informations personnelles, telles que votre nom, votre adresse e-mail et un mot de passe
                        sécurisé. Vous pouvez également vous inscrire via votre compte Google ou Facebook pour une
                        inscription encore plus rapide. Une fois le formulaire soumis, vous recevrez un e-mail de
                        confirmation pour activer votre compte. Après activation, vous pourrez personnaliser votre
                        profil, sauvegarder vos préférences de voyage, et accéder à des offres exclusives réservées aux
                        membres.
                    </p>
                </div>
                <div class="faq-item">
                    <p class="faq-question font-semibold mb-2 cursor-pointer text-gray-800 hover:text-blue-600 animate-fade-in"
                        onclick="toggleAnswer(this)">Comment modifier ou annuler une réservation ?</p>
                    <p class="faq-answer text-gray-600 mb-4 mx-auto max-w-2xl transition-height duration-300"
                        style="overflow: hidden; max-height: 0;" data-expanded="false">
                        Pour modifier ou annuler une réservation, connectez-vous à votre compte FindStay et accédez à la
                        section "Mes Réservations" dans votre profil. Sélectionnez la réservation concernée pour voir
                        les options disponibles. Selon les conditions de l'hébergement, vous pourrez modifier les dates,
                        le type de chambre, ou d'autres détails, sous réserve de disponibilité. Pour annuler, cliquez
                        sur "Annuler la réservation" et suivez les instructions. Notez que les politiques d'annulation
                        varient selon les établissements ; certaines réservations offrent une annulation gratuite
                        jusqu'à une certaine date, tandis que d'autres peuvent entraîner des frais. Vous recevrez une
                        confirmation par e-mail une fois la modification ou l'annulation effectuée. En cas de problème,
                        notre service client est disponible 24/7 pour vous assister.
                    </p>
                </div>
                <div class="faq-item">
                    <p class="faq-question font-semibold mb-2 cursor-pointer text-gray-800 hover:text-blue-600 animate-fade-in"
                        onclick="toggleAnswer(this)">FindStay propose-t-il une application mobile ?</p>
                    <p class="faq-answer text-gray-600 mb-4 mx-auto max-w-2xl transition-height duration-300"
                        style="overflow: hidden; max-height: 0;" data-expanded="false">
                        Oui, FindStay propose une application mobile intuitive disponible sur iOS (via l'App Store) et
                        Android (via Google Play). L'application vous permet de rechercher, réserver et gérer vos
                        séjours en toute simplicité, où que vous soyez. Elle offre des fonctionnalités pratiques comme
                        la recherche par géolocalisation, la synchronisation avec votre calendrier, des notifications
                        pour les offres spéciales, et un accès hors ligne à vos réservations confirmées. L'interface est
                        optimisée pour une navigation fluide, avec des filtres personnalisables et des recommandations
                        basées sur vos préférences. Téléchargez l'application dès aujourd'hui pour planifier vos voyages
                        en un clin d'œil et bénéficier d'une expérience utilisateur optimale.
                    </p>
                </div>
            </div>
        </section>
        <!-- En quelques chiffres -->
        <section id="stats-section" class="w-full bg-[#c5d6e1] h-100">
            <div class="flex flex-col md:flex-row items-center">
                <div class="w-full md:w-1/2 footer_color">
                    <div class="relative flex items-center justify-center h-80">
                        <img src="{{ asset('images/map.png') }}" alt="Carte du Maroc avec logements gérés"
                            class="w-full h-full object-cover rounded-lg">
                        <div class="absolute top-1/4 left-1/6 text-center">
                            <p class="text-5xl md:text-6xl font-bold text-blue-900 mb-2">93</p>
                            <p class="text-sm md:text-base text-black px-2 py-1 rounded">Logements Gérés au Maroc</p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 p-4 md:p-6">
                    <h2 class="text-2xl md:text-3xl font-semibold text-blue-900 mb-4 md:mb-6">En quelques chiffres</h2>
                    <div class="grid grid-cols-2 gap-4 md:gap-6 text-center">
                        <div>
                            <p class="text-3xl md:text-4xl font-bold text-blue-700">
                                {{ $statsData['nombre_reservation'] }}</p>
                            <p class="text-sm md:text-base text-blue-700">JEUNES LOGÉS</p>
                        </div>
                        <div>
                            <p class="text-3xl md:text-4xl font-bold text-blue-700">
                                {{ $statsData['note_moyenne_annonce'] }}%</p>
                            <p class="text-sm md:text-base text-blue-700">Résidences satisfaisantes</p>
                        </div>
                        <div>
                            <p class="text-3xl md:text-4xl font-bold text-blue-700">
                                {{ $statsData['nombre_utilisateur'] }}+</p>
                            <p class="text-sm md:text-base text-blue-700">UTILISATEURS ACTIFS</p>
                        </div>
                        <div>
                            <p class="text-3xl md:text-4xl font-bold text-blue-700">
                                {{ $statsData['nombre_annonce'] }}+</p>
                            <p class="text-sm md:text-base text-blue-700">LOGEMENTS DISPONIBLES</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer_color text-[#2E4053]">
        <div class="container mx-auto px-4">
            <div class="row mb-4 flex justify-center">
                <div class="col-12 text-center mt-1">
                    <div class="contact-info text-blue-900 text-lg font-semibold">
                        <strong>findstay@gmail.com</strong>
                    </div>
                </div>
            </div>
            <div class="row flex flex-wrap justify-center md:justify-between">
                <div class="col-lg-4 col-md-12 mb-6 text-center text-lg-start">
                    <a href="/"
                        class="footer-logo d-flex align-items-center justify-content-center justify-content-lg-start">
                        <img src="{{ asset('images/findStay-removebg-preview.png') }}" alt="FindStay Logo"
                            style="height: 100px; width: auto;">
                    </a>
                    <p class="footer-description text-[#244F76] text-sm">
                        Trouvez votre chez-vous avec FindStay. <br />Facile, rapide, fiable
                    </p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 text-center">
                    <h6 class="footer-title text-lg font-bold mb-4 text-blue-900">Nos Services</h6>
                    <ul class="footer-links space-y-2">
                        <li><a href="#faq-section"
                                class="text-[#244F76] hover:text-[#00DDEB] transition-colors duration-200">FAQ</a></li>
                        <li><a href="#stats-section"
                                class="text-[#244F76] hover:text-[#00DDEB] transition-colors duration-200">En quelques
                                chiffres</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 text-center">
                    <h6 class="footer-title text-lg font-bold mb-4 text-blue-900">Pages</h6>
                    <ul class="footer-links space-y-2">
                        <li><a href="{{ route('login') }}"
                                class="text-[#244F76] hover:text-[#00DDEB] transition-colors duration-200">Connexion</a>
                        </li>
                        <li><a href="{{ route('signup') }}"
                                class="text-[#244F76] hover:text-[#00DDEB] transition-colors duration-200">Inscription</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom border-t border-[#3E4A4B] pt-4 mt-6 text-center">
                <p class="mb-0 text-[#2E4053] text-sm">© 2025 FindStay. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for FAQ Accordion -->
    <script>
        function toggleAnswer(question) {
            const answer = question.nextElementSibling;
            const isExpanded = answer.getAttribute('data-expanded') === 'true';

            if (isExpanded) {
                answer.style.maxHeight = '0';
                answer.setAttribute('data-expanded', 'false');
            } else {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                answer.setAttribute('data-expanded', 'true');
            }
        }
    </script>
</body>

</html>
