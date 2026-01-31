<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - FindStay</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    
    <!-- Navigation Header -->
    <nav class="absolute top-0 left-0 right-0 z-50 p-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                  <div class="flex items-center space-x-2">
                <img src="{{ asset('images/findStay-removebg-preview.png') }}" alt="FindStay Logo"
                        style="height: 150px; width: auto;">
            </div>
            </div>
            <a href="{{ route('signup') }}" class="text-gray-600 hover:text-indigo-600 transition-colors duration-300 flex items-center space-x-2">
                <span>Pas encore membre ?</span>
                <i class="fas fa-user-plus"></i>
            </a>
        </div>
    </nav>
    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4 pt-24">
        <div class="w-full max-w-6xl mx-auto">
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/20">
                <div class="flex flex-col lg:flex-row">
                    
                    <!-- Left Side - Visual -->
                    <div class="lg:w-5/12 relative bg-gradient-to-r from-blue-900 via-blue-700 to-blue-300 p-12 flex flex-col justify-center">
                        <div class="absolute inset-0 bg-black/10"></div>
                        <div class="relative z-10 text-white">
                            <div class="mb-8">
                                <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm">
                                    <i class="fas fa-users text-3xl"></i>
                                </div>
                                <h2 class="text-4xl font-bold mb-4 leading-tight">
                                    Rejoignez notre communauté
                                </h2>
                                <p class="text-xl opacity-90 leading-relaxed">
                                    Trouvez le logement parfait ou les colocataires idéaux en quelques clics
                                </p>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-sm"></i>
                                    </div>
                                    <span>Inscription gratuite et rapide</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-sm"></i>
                                    </div>
                                    <span>Profils vérifiés et sécurisés</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-sm"></i>
                                    </div>
                                    <span>Recherche intelligente</span>
                                </div>
                            </div>
                        </div>
                        <div class="absolute top-10 right-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
                        <div class="absolute bottom-10 left-10 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                    </div>

                    <!-- Right Side - Form -->
                    <div class="lg:w-7/12 p-8 lg:p-12">
                        <div class="max-w-md mx-auto">
                            <div class="text-center mb-8">
                                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                                    Créer votre compte
                                </h1>
                                <p class="text-gray-600">
                                    Commencez votre aventure dès maintenant
                                </p>
                            </div>

                            <form method="POST" action="{{ route('signup') }}" enctype="multipart/form-data" class="space-y-6" id="signupForm">
                                @csrf

                                @if ($errors->any())
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                        <div class="font-bold">Erreur:</div>
                                        <ul class="list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('status'))
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <!-- Row 1: Nom & Prénom -->
                                  <!-- Row 1: Nom & Prénom -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user text-indigo-500 mr-2"></i>
                                            Nom
                                        </label>
                                        <input type="text" name="nom_uti" value="{{ old('nom_uti') }}"
                                               placeholder="Votre nom de famille"
                                               class="form-input" required>
                                        @error('nom_uti')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user text-indigo-500 mr-2"></i>
                                            Prénom
                                        </label>
                                        <input type="text" name="prenom" value="{{ old('prenom') }}"
                                               placeholder="Votre prénom"
                                               class="form-input" required>
                                        @error('prenom')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>
                                        Adresse e-mail
                                    </label>
                                    <input type="email" name="email_uti" value="{{ old('email_uti') }}"
                                           placeholder="exemple@email.com"
                                           class="form-input" required>
                                    @error('email_uti')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Row 2: Téléphone & Date -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-phone text-indigo-500 mr-2"></i>
                                            Téléphone
                                        </label>
                                        <input type="tel" name="tel_uti" value="{{ old('tel_uti') }}"
                                               placeholder="06 12 34 56 78"
                                               class="form-input" required>
                                        @error('tel_uti')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-calendar text-indigo-500 mr-2"></i>
                                            Date de naissance
                                        </label>
                                        <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                                               class="form-input" required>
                                        @error('date_naissance')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Row 3: Ville & Rôle -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>
                                            Ville
                                        </label>
                                        <select name="ville" class="form-select" required>
                                            <option value="" disabled selected>Choisir une ville</option>
                                            <option value="Tanger" {{ old('ville') == 'Tanger' ? 'selected' : '' }}>Tanger</option>
                                            <option value="Tétouan" {{ old('ville') == 'Tétouan' ? 'selected' : '' }}>Tétouan</option>
                                            <option value="Chefchaouen" {{ old('ville') == 'Chefchaouen' ? 'selected' : '' }}>Chefchaouen</option>
                                            <option value="Rabat" {{ old('ville') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                                            <option value="Casablanca" {{ old('ville') == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
                                            <option value="Marrakech" {{ old('ville') == 'Marrakech' ? 'selected' : '' }}>Marrakech</option>
                                            <option value="Fès" {{ old('ville') == 'Fès' ? 'selected' : '' }}>Fès</option>
                                            <option value="Agadir" {{ old('ville') == 'Agadir' ? 'selected' : '' }}>Agadir</option>
                                            <option value="Meknès" {{ old('ville') == 'Meknès' ? 'selected' : '' }}>Meknès</option>
                                            <option value="Oujda" {{ old('ville') == 'Oujda' ? 'selected' : '' }}>Oujda</option>
                                            <option value="Kenitra" {{ old('ville') == 'Kenitra' ? 'selected' : '' }}>Kenitra</option>
                                            <option value="Safi" {{ old('ville') == 'Safi' ? 'selected' : '' }}>Safi</option>
                                            <option value="El Jadida" {{ old('ville') == 'El Jadida' ? 'selected' : '' }}>El Jadida</option>
                                            <option value="Laâyoune" {{ old('ville') == 'Laâyoune' ? 'selected' : '' }}>Laâyoune</option>
                                            <option value="Dakhla" {{ old('ville') == 'Dakhla' ? 'selected' : '' }}>Dakhla</option>
                                        </select>
                                        @error('ville')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user-tag text-indigo-500 mr-2"></i>
                                            Rôle
                                        </label>
                                        <select name="role_uti" class="form-select" required>
                                            <option value="" disabled selected>Choisir votre rôle</option>
                                            <option value="locataire" {{ old('role_uti') == 'locataire' ? 'selected' : '' }}>Locataire</option>
                                            <option value="colocataire" {{ old('role_uti') == 'colocataire' ? 'selected' : '' }}>Colocataire</option>
                                            <option value="proprietaire" {{ old('role_uti') == 'proprietaire' ? 'selected' : '' }}>Propriétaire</option>
                                        </select>
                                        @error('role_uti')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Photo Upload -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-camera text-indigo-500 mr-2"></i>
                                        Photo de profil
                                    </label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" name="photodeprofil_uti" accept="image/*"
                                               class="file-input" id="photo-upload">
                                        <label for="photo-upload" class="file-upload-label">
                                            <i class="fas fa-cloud-upload-alt text-2xl mb-2"></i>
                                            <span class="block">Cliquez pour uploader votre photo</span>
                                            <span class="text-xs text-gray-500">PNG, JPG jusqu'à 5MB</span>
                                        </label>
                                    </div>
                                    @error('photodeprofil_uti')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Passwords -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-lock text-indigo-500 mr-2"></i>
                                            Mot de passe
                                        </label>
                                        <input type="password" name="mot_de_passe_uti"
                                               class="form-input" required>
                                        @error('mot_de_passe_uti')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-lock text-indigo-500 mr-2"></i>
                                            Confirmer
                                        </label>
                                        <input type="password" name="mot_de_passe_uti_confirmation"
                                               class="form-input" required>
                                        @error('mot_de_passe_uti_confirmation')
                                            <div class="form-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                 <button type="submit"  class="btn-primary w-full text-white px-4 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                        <span>Créer un compte</span>
                                        <i class="fas fa-arrow-right ml-2"></i>
                                </button>

                                <!-- Login Link -->
                                <div class="text-center">
                                    <p class="text-gray-600">
                                        Déjà membre ?
                                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors duration-300">
                                            Se connecter
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-group {
            @apply space-y-2;
        }
        .form-label {
            @apply flex items-center text-sm font-medium text-gray-700;
        }
        .form-input {
            @apply w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                   transition-all duration-300 hover:bg-gray-100;
        }
        .form-select {
            @apply w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                   transition-all duration-300 hover:bg-gray-100;
        }
        .form-error {
            @apply text-red-500 text-xs mt-1 flex items-center;
        }
        .file-upload-wrapper {
            @apply relative;
        }
        .file-input {
            @apply absolute inset-0 w-full h-full opacity-0 cursor-pointer;
        }
        .file-upload-label {
            @apply flex flex-col items-center justify-center w-full h-32 bg-gray-50
                   border-2 border-gray-200 border-dashed rounded-xl cursor-pointer
                   hover:bg-gray-100 transition-all duration-300 text-gray-600;
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
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        .form-group:nth-child(5) { animation-delay: 0.5s; }
        .form-group:nth-child(6) { animation-delay: 0.6s; }
        .form-group:nth-child(7) { animation-delay: 0.7s; }
        .form-group:nth-child(8) { animation-delay: 0.8s; }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 2;
        }
        @media (max-width: 768px) {
            .grid {
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
        document.getElementById('photo-upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const label = document.querySelector('.file-upload-label');
            if (file) {
                label.innerHTML = `
                    <i class="fas fa-check-circle text-2xl mb-2 text-green-500"></i>
                    <span class="block text-sm text-gray-600">${file.name}</span>
                    <span class="text-xs text-gray-500">Fichier sélectionné</span>
                `;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    group.style.transition = 'all 0.6s ease-out';
                    group.style.opacity = '1';
                    group.style.transform = 'translateY(0)';
                }, index * 25);
            });

            // Debug form submission
            const signupForm = document.getElementById('signupForm');
            if (signupForm) {
                console.log('Signup form found:', signupForm);
                
                signupForm.addEventListener('submit', function(e) {
                    console.log('Signup form submitted!');
                    console.log('Event:', e);
                    console.log('Form action:', this.action);
                    console.log('Form method:', this.method);
                    
                    const formData = new FormData(this);
                    console.log('Form data:');
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }
                    
                    // Don't prevent default, let it submit normally
                });
                
                // Also check button click
                const submitBtn = signupForm.querySelector('button[type="submit"]');
                if (submitBtn) {
                    console.log('Signup submit button found:', submitBtn);
                    submitBtn.addEventListener('click', function(e) {
                        console.log('Signup submit button clicked!');
                    });
                }
            } else {
                console.error('Signup form not found!');
            }
        });
    </script>
</body>
</html>