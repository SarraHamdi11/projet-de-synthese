<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <h1 class="text-3xl font-semibold text-center text-3xl font-bold mb-8 text-gray-700">Mot de passe oublié</h1>

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

        <form method="POST" action="{{ route('forgot-password') }}">
            @csrf
            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Adresse e-mail</label>
                <div class="flex items-center border rounded px-3 py-2 bg-gray-50 focus-within:ring-2 focus-within:ring-indigo-300">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16 12H8m0 0H6m2 0h8m-6 4h6M6 8h12M6 8v8m12-8v8M6 16h12"></path>
                    </svg>
                    <input type="email" name="email_uti" value="{{ old('email_uti') }}"
                           class="w-full bg-transparent outline-none text-gray-700"
                           placeholder="Entrez votre email" required>
                </div>
            </div>

            <button type="submit"class="btn-primary w-full text-white px-4 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Envoyer le lien de réinitialisation
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
