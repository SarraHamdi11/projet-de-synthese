@extends('layouts.app')

@section('content')

<style>
    .faq-question {
        color: #244F76;
        font-size: 18px;
        font-weight: 600;
        padding: 8px 0;
        transition: all 0.3s ease;
    }
    .faq-question.active {
        font-weight: 700;
        border-left: 4px solid #244F76;
        padding-left: 12px;
    }
    .faq-answer {
        display: none;
        color: #4A4A4A;
        padding: 12px;
        border-radius: 5px;
        font-size: 16px;
        line-height: 1.5;
        margin: 0 0 16px 16px;
        transition: all 0.3s ease;
    }
</style>

<!-- Activité de vos réservations -->
<section class="container mx-auto mb-16">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500 mb-2">Nombre de mes réservations</p>
            <p class="text-xl font-bold">25 demandes</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500 mb-2">Réservations confirmées</p>
            <p class="text-xl font-bold">12 Appartements</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500 mb-2">Réservations refusées</p>
            <p class="text-xl font-bold">8 Appartements</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500 mb-2">Réservations terminées</p>
            <p class="text-xl font-bold">128 messages</p>
        </div>
    </div>
</section>

<!-- Les dernières logements ajoutés -->
<section class="container mx-auto mb-16">
    <h2 class="text-2xl font-semibold mb-6">Les dernières logements ajoutés</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
            <img src="{{ asset('images/house1.jpg') }}" alt="Maison" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="font-semibold text-lg mb-2">Maison indépendante</h3>
                <p class="text-green-600 font-bold">1100 DH / MOIS</p>
                <p class="text-sm text-gray-500">Bni Bouayach</p>
                <div class="mt-2 flex items-center">
                    <span class="text-yellow-400">★★★★★</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="container mx-auto mb-16">
    <h2 class="text-2xl font-semibold mb-6 text-center">FAQ</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="italic">"Service exceptionnel et rapide !"</p>
            <p class="mt-4 font-bold">Cassie Williamson</p>
        </div>
    </div>
    <div class="text-center space-y-4">
        <div class="faq-item">
            <p class="faq-question font-semibold mb-2 cursor-pointer text-gray-800 hover:text-blue-600" onclick="toggleAnswer(this)">Qu'est-ce que FindStay ?</p>
            <p class="faq-answer text-gray-600 mb-4 mx-auto max-w-2xl">FindStay est une plateforme qui vous aide à trouver facilement des hébergements de qualité...</p>
        </div>
        <div class="faq-item">
            <p class="faq-question font-semibold mb-2 cursor-pointer text-gray-800 hover:text-blue-600" onclick="toggleAnswer(this)">Comment créer un compte sur FindStay ?</p>
            <p class="faq-answer text-gray-600 mb-4 mx-auto max-w-2xl">Pour créer un compte, cliquez sur 'S'inscrire' et remplissez le formulaire...</p>
        </div>
        <div class="faq-item">
            <p class="faq-question font-semibold mb-2 cursor-pointer text-gray-800 hover:text-blue-600" onclick="toggleAnswer(this)">Comment modifier ou annuler une réservation ?</p>
            <p class="faq-answer text-gray-600 mb-4 mx-auto max-w-2xl">Vous pouvez modifier ou annuler une réservation depuis votre profil...</p>
        </div>
        <div class="faq-item">
            <p class="faq-question font-semibold mb-2 cursor-pointer text-gray-800 hover:text-blue-600" onclick="toggleAnswer(this)">FindStay propose-t-il une application mobile ?</p>
            <p class="faq-answer text-gray-600 mb-4 mx-auto max-w-2xl">Oui, FindStay propose une application mobile disponible sur iOS et Android...</p>
        </div>
    </div>
</section>

<!-- En quelques chiffres -->
<section class="w-full bg-[#c5d6e1]">
    <div class="flex flex-col md:flex-row items-center">
        <!-- Colonne de la carte -->
        <div class="w-full md:w-1/2">
            <div class="relative flex items-center justify-center min-h-[25vh]">
                <img src="{{ asset('images/map.png') }}" alt="Carte du Maroc" class="w-full h-full object-cover rounded-lg">
                <div class="absolute top-1/4 left-1/6 text-center">
                    <p class="text-5xl md:text-6xl font-bold text-black mb-2">93</p>
                    <p class="text-sm md:text-base text-black px-2 py-1 rounded">Logements Gérés au Maroc</p>
                </div>
            </div>
        </div>

        <!-- Colonne des chiffres -->
        <div class="w-full md:w-1/2 p-4 md:p-6">
            <h2 class="text-2xl md:text-3xl font-semibold text-blue-900 mb-4 md:mb-6">En Quelques chiffres</h2>
            <div class="grid grid-cols-2 gap-4 md:gap-6 text-center">
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-blue-700">2000</p>
                    <p class="text-sm md:text-base text-blue-700">JEUNES LOGÉS</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-blue-700">88%</p>
                    <p class="text-sm md:text-base text-blue-700">Résidences satisfaisantes</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-blue-700">800+</p>
                    <p class="text-sm md:text-base text-blue-700">UTILISATEURS ACTIFS</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-blue-700">90+</p>
                    <p class="text-sm md:text-base text-blue-700">LOGEMENTS DISPONIBLES</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleAnswer(element) {
        const answer = element.nextElementSibling;
        const allAnswers = document.querySelectorAll('.faq-answer');
        const allQuestions = document.querySelectorAll('.faq-question');
        allAnswers.forEach(ans => {
            if (ans !== answer) {
                ans.style.display = 'none';
            }
        });
        allQuestions.forEach(q => {
            q.classList.remove('text-blue-600');
        });
        if (answer.style.display === 'block') {
            answer.style.display = 'none';
            element.classList.remove('text-blue-600');
        } else {
            answer.style.display = 'block';
            element.classList.add('text-blue-600');
        }
    }
</script>
@endsection