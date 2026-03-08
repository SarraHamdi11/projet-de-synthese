<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindStay - Your Property, Our Excellence</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); }
        .font-display { font-family: 'Playfair Display', serif; }
        
        .hero-section {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(59, 130, 246, 0.8) 100%), url('{{ asset('images/header_images.jpg') }}');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-content {
            text-align: center;
            color: white;
            animation: fadeInUp 1s ease-out;
        }
        
        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 900;
            margin-bottom: 1.5rem;
            font-family: 'Playfair Display', serif;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .hero-subtitle {
            font-size: clamp(1.1rem, 2.5vw, 1.5rem);
            font-weight: 300;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn-hero {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 0.5rem;
        }
        
        .btn-primary-hero {
            background: white;
            color: #1e3a8a;
        }
        
        .btn-primary-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
        }
        
        .btn-secondary-hero {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary-hero:hover {
            background: white;
            color: #1e3a8a;
            transform: translateY(-3px);
        }
        
        .enhanced-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .enhanced-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e3a8a;
            margin-bottom: 0.5rem;
            font-family: 'Playfair Display', serif;
        }
        
        .stat-label {
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .property-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .property-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .property-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .property-card:hover .property-image {
            transform: scale(1.05);
        }
        
        .property-content {
            padding: 1.5rem;
        }
        
        .property-type {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
            font-family: 'Playfair Display', serif;
        }
        
        .property-price {
            font-size: 1.3rem;
            font-weight: 800;
            color: #f59e0b;
            margin-bottom: 0.5rem;
        }
        
        .star {
            color: #fbbf24;
            font-size: 1.1rem;
        }
        
        .section-title {
            font-size: clamp(2rem, 5vw, 2.5rem);
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 1rem;
            font-family: 'Playfair Display', serif;
            text-align: center;
        }
        
        .section-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta-section {
            background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
            padding: 5rem 0;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .btn-cta {
            background: white;
            color: #1e3a8a;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 0.5rem;
        }
        
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .hero-buttons { flex-direction: column; align-items: center; }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <header class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Find Your Ideal Property</h1>
            <p class="hero-subtitle">Discover exceptional accommodations across Morocco with FindStay</p>
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-hero btn-primary-hero">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </a>
                <a href="{{ route('signup') }}" class="btn-hero btn-secondary-hero">
                    <i class="fas fa-user-plus"></i> Sign Up
                </a>
            </div>
        </div>
    </header>

    <!-- Cities Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="section-title">Popular Cities</h2>
            <p class="section-subtitle">Explore our properties in the most sought-after cities</p>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-city"></i></div>
                    <div class="font-bold text-lg">Casablanca</div>
                    <div class="text-gray-600">250+ properties</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-mosque"></i></div>
                    <div class="font-bold text-lg">Marrakech</div>
                    <div class="text-gray-600">180+ properties</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-umbrella-beach"></i></div>
                    <div class="font-bold text-lg">Agadir</div>
                    <div class="text-gray-600">120+ properties</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-mountain"></i></div>
                    <div class="font-bold text-lg">Fès</div>
                    <div class="text-gray-600">95+ properties</div>
                </div>
                <div class="enhanced-card">
                    <div class="stat-icon"><i class="fas fa-anchor"></i></div>
                    <div class="font-bold text-lg">Tanger</div>
                    <div class="text-gray-600">85+ properties</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Properties Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="section-title scroll-animate">Latest Properties</h2>
            <p class="section-subtitle scroll-animate">Discover our most recent properties</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Sample Properties -->
                <div class="property-card scroll-animate">
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&h=400&fit=crop" alt="Appartement" class="property-image">
                    <div class="property-content">
                        <h3 class="property-type">Modern Apartment</h3>
                        <div class="property-price">8,500 DH/month</div>
                        <div class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt"></i> Casablanca</div>
                        <div class="flex justify-center gap-1">
                            <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                        </div>
                    </div>
                </div>
                
                <div class="property-card scroll-animate">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=600&h=400&fit=crop" alt="Villa" class="property-image">
                    <div class="property-content">
                        <h3 class="property-type">Luxury Villa</h3>
                        <div class="property-price">15,000 DH/month</div>
                        <div class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt"></i> Marrakech</div>
                        <div class="flex justify-center gap-1">
                            <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">☆</span>
                        </div>
                    </div>
                </div>
                
                <div class="property-card scroll-animate">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=600&h=400&fit=crop" alt="Studio" class="property-image">
                    <div class="property-content">
                        <h3 class="property-type">Downtown Studio</h3>
                        <div class="property-price">4,200 DH/month</div>
                        <div class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt"></i> Rabat</div>
                        <div class="flex justify-center gap-1">
                            <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Stats Section -->
    <section class="stats-section">
        <div class="container mx-auto px-4">
            <h2 class="section-title text-white scroll-animate">Numbers That Speak</h2>
            <p class="section-subtitle text-white opacity-90 scroll-animate">Excellence of our service through impressive statistics</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center scroll-animate">
                    <div class="stat-icon"><i class="fas fa-home"></i></div>
                    <div class="stat-number" data-target="1250">0</div>
                    <div class="stat-label">Available Properties</div>
                </div>
                <div class="text-center scroll-animate">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number" data-target="85000">0</div>
                    <div class="stat-label">Active Users</div>
                </div>
                <div class="text-center scroll-animate">
                    <div class="stat-icon"><i class="fas fa-star"></i></div>
                    <div class="stat-number" data-target="4.9">0</div>
                    <div class="stat-label">Customer Satisfaction</div>
                </div>
                <div class="text-center scroll-animate">
                    <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-number" data-target="320">0</div>
                    <div class="stat-label">Monthly Reservations</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced CTA Section -->
    <section class="cta-section" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); padding: 5rem 0; text-align: center; color: white; position: relative;">
        <div class="container mx-auto px-4">
            <h2 class="section-title text-white scroll-animate">Ready to Find Your Home?</h2>
            <p class="section-subtitle text-white opacity-90 scroll-animate">Join thousands of satisfied customers</p>
            <div class="flex justify-center flex-wrap gap-4 scroll-animate">
                <a href="{{ route('signup') }}" class="btn btn-white">
                    <i class="fas fa-rocket"></i>
                    Get Started Now
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </a>
            </div>
        </div>
    </section>
    </main>

    <!-- Enhanced Footer -->
    <footer class="footer" style="background: #1f2937; color: white; padding: 3rem 0 1rem;">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">FindStay</h3>
                    <p class="mb-4">Find your home with FindStay. Easy, fast, reliable.</p>
                    <div class="flex gap-4">
                        <a href="#" class="text-2xl hover:text-blue-400 transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-2xl hover:text-blue-400 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-2xl hover:text-pink-400 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-2xl hover:text-blue-400 transition"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Services</h3>
                    <div class="footer-links space-y-2">
                        <a href="#properties" class="block hover:text-blue-400 transition">Properties</a>
                        <a href="#stats" class="block hover:text-blue-400 transition">Statistics</a>
                        <a href="#" class="block hover:text-blue-400 transition">About</a>
                        <a href="#" class="block hover:text-blue-400 transition">Contact</a>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Pages</h3>
                    <div class="footer-links space-y-2">
                        <a href="{{ route('login') }}" class="block hover:text-blue-400 transition">Login</a>
                        <a href="{{ route('signup') }}" class="block hover:text-blue-400 transition">Sign Up</a>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact</h3>
                    <p><i class="fas fa-envelope"></i> findstay@gmail.com</p>
                    <p><i class="fas fa-phone"></i> +212 5XX XXX XXX</p>
                    <p><i class="fas fa-map-marker-alt"></i> Maroc</p>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-4 text-center">
                <p>&copy; 2025 FindStay. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Enhanced animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            const animateElements = document.querySelectorAll('.scroll-animate');
            animateElements.forEach(el => observer.observe(el));
            
            // Animate stats immediately on page load
            document.querySelectorAll('.stat-number').forEach(stat => {
                const target = parseFloat(stat.getAttribute('data-target'));
                if (!isNaN(target)) {
                    animateCounter(stat, target);
                }
            });
        });

        // Counter animation for stats
        function animateCounter(element, target, duration = 2000) {
            const start = 0;
            const increment = target / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                
                if (target % 1 === 0) {
                    element.textContent = Math.floor(current).toLocaleString() + '+';
                } else {
                    element.textContent = current.toFixed(1);
                }
            }, 16);
        }

        // Animate stats when they come into view (backup)
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    const target = parseFloat(entry.target.getAttribute('data-target'));
                    if (!isNaN(target)) {
                        animateCounter(entry.target, target);
                        entry.target.classList.add('animated');
                    }
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.stat-number').forEach(stat => {
            statsObserver.observe(stat);
        });

        // Smooth scroll
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

    <style>
        .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .scroll-animate.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .property-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f3f4f6;
        }

        .property-card:hover {
            transform: translateY(-8px);
            border-color: #1e3a8a;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .property-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .property-card:hover .property-image {
            transform: scale(1.05);
        }

        .property-content {
            padding: 1.5rem;
        }

        .property-type {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
            font-family: 'Playfair Display', serif;
        }

        .property-price {
            font-size: 1.3rem;
            font-weight: 800;
            color: #ea580c;
            margin-bottom: 0.5rem;
        }

        .star {
            color: #fbbf24;
            font-size: 1.1rem;
        }

        .stats-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 5rem 0;
            color: white;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            font-family: 'Playfair Display', serif;
        }

        .stat-label {
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.9;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 1rem;
            font-family: 'Playfair Display', serif;
            text-align: center;
        }

        .section-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
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
            font-family: 'Inter', sans-serif;
        }

        .btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
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
            color: #1e3a8a;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: white;
        }
    </style>
</body>

</html>
