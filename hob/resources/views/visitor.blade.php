<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindStay - Votre Propriété, Notre Excellence</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@900&family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #0f766e; --primary-light: #14b8a6; --primary-dark: #0d5a54; --accent: #ea580c; }
        body { font-family: 'Poppins', sans-serif; background: #f9fafb; margin: 0; }
        .font-display { font-family: 'Playfair Display', serif; }
        
        .hero-section {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 8s ease-in-out infinite;
        }
        
        .floating-circle:nth-child(1) { width: 120px; height: 120px; top: 10%; left: 10%; animation-delay: 0s; }
        .floating-circle:nth-child(2) { width: 80px; height: 80px; top: 20%; right: 15%; animation-delay: 2s; }
        .floating-circle:nth-child(3) { width: 150px; height: 150px; bottom: 20%; left: 20%; animation-delay: 4s; }
        .floating-circle:nth-child(4) { width: 60px; height: 60px; top: 60%; right: 25%; animation-delay: 6s; }
        .floating-circle:nth-child(5) { width: 100px; height: 100px; bottom: 10%; right: 10%; animation-delay: 1s; }
        
        .hero-content {
            text-align: center;
            color: white;
            z-index: 10;
            position: relative;
            max-width: 1200px;
            padding: 0 2rem;
        }
        
        .hero-title {
            font-size: 4.5rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            font-family: 'Playfair Display', serif;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.8s ease-out;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 300;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0.9;
            animation: fadeInUp 0.8s ease-out 0.1s;
            animation-fill-mode: both;
        }
        
        .search-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 3rem;
            animation: fadeInUp 0.8s ease-out 0.2s;
            animation-fill-mode: both;
        }
        
        .search-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }
        
        .search-input {
            padding: 1rem 1.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: white;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
        }
        
        .search-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #1a1a1a;
            font-size: 0.9rem;
        }
        
        .btn {
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
        }
        
        .btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        }
        
        .btn-primary {
            background: var(--accent);
            color: white;
        }
        
        .btn-primary:hover {
            background: #dc2626;
        }
        
        .btn-white {
            background: white;
            color: #1a1a1a;
        }
        
        .btn-white:hover {
            background: #f9fafb;
        }
        
        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-outline:hover {
            background: white;
            color: var(--primary);
        }
        
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease-out 0.3s;
            animation-fill-mode: both;
        }
        
        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite;
            cursor: pointer;
        }
        
        .scroll-indicator i {
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(40px); }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
            40% { transform: translateX(-50%) translateY(-10px); }
            60% { transform: translateX(-50%) translateY(-5px); }
        }
        
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .search-grid { grid-template-columns: 1fr; gap: 1rem; }
            .hero-buttons { flex-direction: column; align-items: center; }
            .floating-circle { display: none; }
        }
    </style>
</head>

<body>
    <!-- Enhanced Hero Section -->
    <section class="hero-section">
        <!-- Floating Circles -->
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        
        <div class="hero-content">
            <h1 class="hero-title">Trouvez Votre Logement Idéal</h1>
            <p class="hero-subtitle">Découvrez des logements exceptionnels à travers le Maroc avec FindStay</p>
            
            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-grid">
                    <div>
                        <label class="search-label">Destination</label>
                        <input type="text" placeholder="Où allez-vous ?" class="search-input">
                    </div>
                    <div>
                        <label class="search-label">Date d'arrivée</label>
                        <input type="date" class="search-input">
                    </div>
                    <div>
                        <label class="search-label">Date de départ</label>
                        <input type="date" class="search-input">
                    </div>
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Rechercher
                    </button>
                </div>
            </div>
            
            <!-- Hero Buttons -->
            <div class="hero-buttons">
                <a href="#properties" class="btn btn-white">
                    <i class="fas fa-compass"></i>
                    Découvrir Maintenant
                </a>
                <a href="#about" class="btn btn-outline">
                    <i class="fas fa-info-circle"></i>
                    En Savoir Plus
                </a>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="scroll-indicator" onclick="document.getElementById('cities').scrollIntoView({behavior: 'smooth'})">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="section-title">Des Chiffres Qui Parlent</h2>
            <p class="section-subtitle">L'excellence de notre service à travers des statistiques impressionnantes</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-home"></i></div>
                    <div class="stat-number">{{ $statsData['nombre_annonce'] }}+</div>
                    <div class="stat-label">Logements Disponibles</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number">{{ $statsData['nombre_utilisateur'] }}+</div>
                    <div class="stat-label">Utilisateurs Actifs</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-star"></i></div>
                    <div class="stat-number">{{ $statsData['note_moyenne_annonce'] }}%</div>
                    <div class="stat-label">Satisfaction Client</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-number">{{ $statsData['nombre_reservation'] }}</div>
                    <div class="stat-label">Réservations Mensuelles</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cities Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="section-title">Villes Populaires</h2>
            <p class="section-subtitle">Explorez nos logements dans les villes les plus recherchées</p>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-city"></i></div>
                    <div class="font-bold text-lg">Casablanca</div>
                    <div class="text-gray-600">250+ logements</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-mosque"></i></div>
                    <div class="font-bold text-lg">Marrakech</div>
                    <div class="text-gray-600">180+ logements</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-umbrella-beach"></i></div>
                    <div class="font-bold text-lg">Agadir</div>
                    <div class="text-gray-600">120+ logements</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-mountain"></i></div>
                    <div class="font-bold text-lg">Fès</div>
                    <div class="text-gray-600">95+ logements</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-anchor"></i></div>
                    <div class="font-bold text-lg">Tanger</div>
                    <div class="text-gray-600">85+ logements</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Properties Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="section-title">Dernières Propriétés</h2>
            <p class="section-subtitle">Découvrez nos logements les plus récents</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($latestLogements as $logement)
                    <div class="property-card">
                        <img src="{{ !empty($logement->photos) ? asset('images/' . (is_array($logement->photos) ? $logement->photos[0] : json_decode($logement->photos, true)[0])) : asset('images/placeholder.jpg') }}" 
                             alt="{{ $logement->type_log }} à {{ $logement->ville }}" 
                             class="property-image">
                        <div class="property-content">
                            <h3 class="property-type">{{ ucfirst($logement->type_log) }}</h3>
                            <div class="property-price">{{ number_format($logement->prix_log, 0) }} DH/mois</div>
                            <div class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt"></i> {{ $logement->ville }}</div>
                            <div class="flex justify-center gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $logement->average_note)
                                        <span class="star">★</span>
                                    @else
                                        <span class="star">☆</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center col-span-full">
                        <p class="text-gray-600">Aucun logement récent disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container mx-auto px-4">
            <h2 class="section-title text-white">Prêt à Trouver Votre Chez-Vous ?</h2>
            <p class="section-subtitle text-white opacity-90">Rejoignez des milliers de clients satisfaits</p>
            <div class="flex justify-center flex-wrap">
                <a href="{{ route('signup') }}" class="btn-cta">
                    <i class="fas fa-rocket"></i> Commencer Maintenant
                </a>
                <a href="{{ route('login') }}" class="btn-cta">
                    <i class="fas fa-sign-in-alt"></i> Se Connecter
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">FindStay</h3>
                    <p class="mb-4">Trouvez votre chez-vous avec FindStay. Facile, rapide, fiable.</p>
                    <div class="flex gap-4">
                        <a href="#" class="text-2xl hover:text-blue-400 transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-2xl hover:text-blue-400 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-2xl hover:text-pink-400 transition"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Pages</h3>
                    <div class="space-y-2">
                        <a href="{{ route('login') }}" class="block hover:text-blue-400 transition">Connexion</a>
                        <a href="{{ route('signup') }}" class="block hover:text-blue-400 transition">Inscription</a>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact</h3>
                    <p><i class="fas fa-envelope"></i> findstay@gmail.com</p>
                    <p><i class="fas fa-phone"></i> +212 5XX XXX XXX</p>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-4 text-center">
                <p>&copy; 2025 FindStay. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
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
