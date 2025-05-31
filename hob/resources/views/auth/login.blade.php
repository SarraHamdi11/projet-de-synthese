<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue à nouveau</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="login-container bg-white rounded-lg overflow-hidden max-w-5xl w-full flex flex-col md:flex-row">
        <!-- Image à gauche -->
        <div class="w-full md:w-2/5 relative">
           <img src="{{ asset('images/your-image-file.jpg') }}" alt="Login Image" style="width: 100%; height: 80%; margin-top:10%; margin-left:20px; border-radius: 8px;">
           
        </div>
        
        <!-- Formulaire à droite -->
        <div class="w-full md:w-3/5 p-8 md:p-12">
            <h1 class="text-3xl font-bold mb-8 text-gray-700">Bienvenue à nouveau</h1>
            
            @if ($errors->has('login'))
                <div class="text-red-500 mb-4">{{ $errors->first('login') }}</div>
            @endif
            @if (session('status'))
                <div class="text-green-500 mb-4">{{ session('status') }}</div>
            @endif
            
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-gray-600 text-sm mb-2">Adresse e-mail ou numéro de téléphone</label>
                    <input type="text" name="login" value="{{ Cookie::get('user_login') ?? old('login') }}"
                           class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label class="block text-gray-600 text-sm mb-2">Mot de passe</label>
                    <input type="password" name="password" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember" class="text-gray-600 text-sm">Se souvenir de moi</label>
                    <a href="{{ route('forgot-password') }}" class="text-blue-500 hover:underline text-sm ml-auto">Mot de passe oublié ?</a>
                </div>
                
                <button type="submit" class="btn-primary w-full text-white px-4 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Se connecter
                </button>
                
                <div class="text-center text-sm text-gray-600">
                    Vous n'avez pas de compte ? <a href="{{ route('signup') }}" class="text-blue-500 hover:underline">Créer un compte gratuit</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>