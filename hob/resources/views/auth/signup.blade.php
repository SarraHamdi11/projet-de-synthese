<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 pt-20 ">
    

<div class="bg-gray-100 min-h-screen flex items-center justify-center p-4">*
    
    <div class="login-container bg-white rounded-lg overflow-hidden flex flex-col md:flex-row">
        
        <!-- Image à gauche -->
        <div class="w-full md:w-4/5 relative pt-10">
            <img src="{{ asset('images/your-image-file.jpg') }}" alt="Signup Image"
                 style="width: 100%; height: 80%; margin-top:10%; margin-left:20px; border-radius: 8px;">
        </div>

        <!-- Formulaire à droite -->
        <div class="w-full md:w-3/5 p-8 md:p-12">
               <h1 class="text-4xl font-bold mb-8 text-gray-700 text-center">Créer un compte gratuit</h1>


            <form method="POST" action="{{ route('signup') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                @foreach ([
                    'tel_uti' => 'Numéro de téléphone',
                    'email_uti' => 'Adresse e-mail',
                    'nom_uti' => 'Nom',
                    'prenom' => 'Prénom',
                    'ville' => 'Ville',
                    'date_naissance' => 'Date de naissance',
                ] as $name => $label)
                <div>
                    <label class="block text-gray-600 text-sm mb-2 text-left">{{ $label }}</label>
                    @error($name)
                        <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                    @enderror
                    <input type="{{ $name == 'date_naissance' ? 'date' : 'text' }}"
                           name="{{ $name }}"
                           value="{{ old($name) }}"
                           class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                @endforeach

                <!-- Rôle -->
                <div>
                    <label class="block text-gray-600 text-sm mb-2">Rôle</label>
                    @error('role_uti')
                        <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                    @enderror
                    <select name="role_uti" class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="locataire">Locataire</option>
                        <option value="colocataire">Colocataire</option>
                        <option value="proprietaire">Propriétaire</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Photo -->
                <div>
                    <label class="block text-gray-600 text-sm mb-2">Photo de profil</label>
                    @error('photodeprofil_uti')
                        <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                    @enderror
                    <input type="file" name="photodeprofil_uti" accept="image/*"
                           class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Mot de passe -->
                <div>
                    <label class="block text-gray-600 text-sm mb-2">Mot de passe</label>
                    @error('mot_de_passe_uti')
                        <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                    @enderror
                    <input type="password" name="mot_de_passe_uti"
                           class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Confirmation -->
                <div>
                    <label class="block text-gray-600 text-sm mb-2">Confirmer le mot de passe</label>
                    @error('mot_de_passe_uti_confirmation')
                        <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                    @enderror
                    <input type="password" name="mot_de_passe_uti_confirmation"
                           class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Bouton -->
                <button type="submit"
                        class="btn-primary w-full text-white px-4 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Créer un compte
                </button>

                <!-- Lien vers login -->
                <div class="text-center text-sm text-gray-600">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Se connecter</a>
                </div>
            </form>
        </div>
    </div>
</div>

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
</style>


</body>
</html>