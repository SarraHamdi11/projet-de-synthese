<!DOCTYPE html>
<html>
<head>
    <title>Visitor Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4 text-center">Welcome to Our Platform</h1>
        <p class="mb-6 text-gray-600 text-center">
            Join our community to find or offer housing solutions. Sign up or log in to get started!
        </p>
        <div class="flex justify-center space-x-4">
        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</a>          
          <a href="{{ route('signup') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Sign Up</a>
        </div>
    </div>
</body>
</html>