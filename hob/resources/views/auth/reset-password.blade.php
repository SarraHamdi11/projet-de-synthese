<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <h1 class="text-3xl font-semibold text-center font-bold mb-8 text-gray-700">Réinitialisation du mot de passe</h1>
        
        @if (session('status'))
            <div class="mb-4 text-green-600 bg-green-100 border border-green-300 p-3 rounded text-sm">
                {{ session('status') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="mb-4 text-red-600 bg-red-100 border border-red-300 p-3 rounded text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Adresse e-mail</label>
                <div class="flex items-center border rounded px-3 py-2 bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-300">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                    <input type="email" name="email_uti" id="email_uti" value="{{ $email ?? old('email_uti') }}" class="w-full bg-transparent outline-none text-gray-700" readonly>
                </div>
                <p class="text-sm text-gray-500 mt-1">Votre adresse email est pré-remplie et ne peut pas être modifiée</p>
            </div>
            
            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Nouveau mot de passe</label>
                <div class="flex items-center border rounded px-3 py-2 bg-gray-50 focus-within:ring-2 focus-within:ring-indigo-300">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <input type="password" name="password" id="password" class="w-full bg-transparent outline-none text-gray-700" placeholder="Minimum 8 caractères" required>
                </div>
                <p class="text-sm text-gray-500 mt-1">Votre mot de passe doit contenir au moins 8 caractères</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Confirmation du mot de passe</label>
                <div class="flex items-center border rounded px-3 py-2 bg-gray-50 focus-within:ring-2 focus-within:ring-indigo-300">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-transparent outline-none text-gray-700" placeholder="Confirmez votre nouveau mot de passe" required>
                </div>
            </div>
            
            <button type="submit" class="btn-primary w-full text-white px-4 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Réinitialiser mon mot de passe
            </button>
        </form>
    </div>
</body>
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
</html>