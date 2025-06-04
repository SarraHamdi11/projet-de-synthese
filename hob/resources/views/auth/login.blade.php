<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter - FindStay</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    
    <!-- Navigation Header -->
    <nav class="absolute top-0 left-0 right-0 z-50 p-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/findStay-removebg-preview.png') }}" alt="FindStay Logo"
                        style="height: 150px; width: auto;">
            </div>
            <a href="{{ route('signup') }}" class="text-gray-600 hover:text-indigo-600 transition-colors duration-300 flex items-center space-x-2">
                <span>Pas encore membre ?</span>
                <i class="fas fa-user-plus"></i>
            </a>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4 pt-24">
        <div class="w-full max-w-2xl mx-auto">
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/20">
    

                    <!-- Right Side - Form -->
                    <div class=" p-8 lg:p-12">
                        <div class="max-w-md mx-auto">
                            <div class="text-center mb-8">
                                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                                    Se connecter
                                </h1>
                                <p class="text-gray-600">
                                    Bienvenue à nouveau sur FindStay
                                </p>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                                @csrf

                                @if ($errors->has('login'))
                                    <div class="text-red-500 text-sm mb-4 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $errors->first('login') }}
                                    </div>
                                @endif
                                @if (session('status'))
                                    <div class="text-green-500 text-sm mb-4 flex items-center">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        {{ session('status') }}
                                    </div>
                                @endif

<!-- Email/Phone -->
<div class="form-group mb-4">
    <label class="form-label block mb-1">
        <i class="fas fa-envelope text-indigo-500 mr-2"></i>
        Adresse e-mail ou numéro de téléphone
    </label>
    <input type="text" name="login" placeholder="Entrez votre e-mail ou téléphone"
           value="{{ Cookie::get('user_login') ?? old('login') }}"
           class="form-input border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
    @error('login')
        <div class="form-error">{{ $message }}</div>
    @enderror
</div>

<!-- Password -->
<div class="form-group mb-4">
    <label class="form-label block mb-1">
        <i class="fas fa-lock text-indigo-500 mr-2"></i>
        Mot de passe
    </label>
    <input type="password" name="password" placeholder="Entrez votre mot de passe"
           class="form-input border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
    @error('password')
        <div class="form-error">{{ $message }}</div>
    @enderror
</div>


                                <!-- Remember Me & Forgot Password -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="remember" id="remember" class="mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="remember" class="text-gray-600 text-sm">Se souvenir de moi</label>
                                    </div>
                                    <a href="{{ route('forgot-password') }}" class="text-indigo-600 hover:text-indigo-700 text-sm transition-colors duration-300">
                                        Mot de passe oublié ?
                                    </a>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"  class="btn-primary w-full text-white px-4 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                     <a href="{{ route('login') }}" class="btn-secondary">
                                        <span>Se connecter</span>
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </button>

                                <!-- Signup Link -->
                                <div class="text-center">
                                    <p class="text-gray-600">
                                        Pas encore membre ?
                                        <a href="{{ route('signup') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors duration-300">
                                            Créer un compte
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>

    <style>
        .form-group {
            @apply space-y-5;
        }
        .form-label {
            @apply flex items-center text-sm font-medium text-gray-700;
        }
        .form-input {
            @apply w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                   transition-all duration-300 hover:bg-gray-100;
        }
        .form-error {
            @apply text-red-500 text-xs mt-1 flex items-center;
        }
        .btn-primary {
            @apply w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white
                   py-4 px-6 rounded-xl font-medium text-lg flex items-center justify-center
                   hover:from-indigo-700 hover:to-purple-700 transform hover:scale-[1.02]
                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                   transition-all duration-300 shadow-lg hover:shadow-xl;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .form-group {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }
        @media (max-width: 768px) {
            .grid-cols-2 {
                @apply grid-cols-1;
            }
        }
        
         .btn-primary {
        background-color: #335c81;
        transition: background-color 0.3s;
    }
    .btn-primary:hover {
        background-color: #274a67;
    }
        
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    group.style.transition = 'all 0.6s ease-out';
                    group.style.opacity = '1';
                    group.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
