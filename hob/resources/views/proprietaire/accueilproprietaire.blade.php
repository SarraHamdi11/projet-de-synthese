@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
:root {
  --creme: #EBDFD5;
  --creme-50: rgba(235, 223, 213, 0.5);
  --dark-blue: #244F76;
  --medium-blue: #447892;
  --light-blue: #7C9FC0;
  --white: #fff;
}
body { font-family: 'Poppins', sans-serif; background: #fff !important; }
.section-title {
  font-family: 'Inknut Antiqua', serif;
  font-size: 2.3rem;
  font-weight: 900;
  color: var(--dark-blue);
  background: linear-gradient(90deg, var(--dark-blue), var(--medium-blue));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 2rem;
  letter-spacing: 1px;
  position: relative;
  animation: fadeInDown 1s cubic-bezier(.4,2,.3,1);
}
@keyframes fadeInDown { from { opacity:0; transform:translateY(-40px);} to {opacity:1;transform:translateY(0);} }
.fade-in-up { opacity:0; transform:translateY(40px); transition:all 0.8s cubic-bezier(.4,2,.3,1); }
.fade-in-up.visible { opacity:1; transform:translateY(0); }
.fade-in-left { opacity:0; transform:translateX(-40px); transition:all 0.8s cubic-bezier(.4,2,.3,1); }
.fade-in-left.visible { opacity:1; transform:translateX(0); }
.fade-in-right { opacity:0; transform:translateX(40px); transition:all 0.8s cubic-bezier(.4,2,.3,1); }
.fade-in-right.visible { opacity:1; transform:translateX(0); }
.stats-glass {
  background: var(--creme);
  border-radius: 1.2rem;
  box-shadow: 0 4px 16px #44789222;
  min-height: 180px;
  max-height: 220px;
  padding: 1.5rem 1.2rem;
  text-align: center;
  color: var(--medium-blue);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  transition: box-shadow 0.4s, transform 0.4s, background 0.4s;
  position: relative;
  overflow: hidden;
  animation: fadeInUpStats 1s cubic-bezier(.4,2,.3,1);
}
@keyframes fadeInUpStats { from { opacity:0; transform:translateY(40px) scale(0.97);} to {opacity:1;transform:translateY(0) scale(1);} }
.stats-glass:hover {
  box-shadow: 0 12px 32px #44789233, 0 2px 8px #244F7633;
  background: linear-gradient(120deg, var(--creme) 80%, #fff 100%);
  transform: scale(1.035) rotate(-1deg);
}
.stats-glass .stats-icon {
  font-size: 2.7rem;
  color: var(--dark-blue);
  margin-bottom: 0.7rem;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: popIcon 2.5s infinite cubic-bezier(.4,2,.3,1);
}
@keyframes popIcon { 0%,100%{transform:scale(1);} 50%{transform:scale(1.08);} }
.stats-title {
  font-family: 'Inknut Antiqua', serif;
  color: var(--dark-blue);
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 0.7rem;
}
.stats-value {
  font-family: 'Poppins', sans-serif;
  color: var(--medium-blue);
  font-size: 1.05rem;
  font-weight: 600;
  margin-top: 0.2rem;
}
@media (max-width: 991px) {
  .stats-glass { min-height: 140px; max-height: 180px; padding: 1rem 0.5rem; }
  .stats-glass .stats-icon { font-size: 2rem; }
  .stats-title { font-size: 1rem; }
  .stats-value { font-size: 0.98rem; }
}
.card-3d {
  background: var(--white);
  border-radius: 1.5rem;
  box-shadow: 0 4px 24px #44789222, 0 1.5px 6px #7C9FC0;
  border: none;
  transition: transform 0.5s cubic-bezier(.4,2,.3,1), box-shadow 0.5s;
  perspective: 800px;
  will-change: transform;
  overflow: hidden;
  min-height: 320px;
}
.card-3d:hover {
  transform: rotateY(8deg) scale(1.04) translateY(-8px);
  box-shadow: 0 16px 48px #44789233, 0 8px 24px #244F7633;
}
.card-3d .card-img-top { height: 180px; object-fit: cover; transition: transform 0.4s; }
.card-3d:hover .card-img-top { transform: scale(1.08) rotate(-2deg); }
.card-3d .card-title { font-family: 'Inknut Antiqua', serif; color: var(--dark-blue); font-size: 1.1rem; }
.card-3d .price { color: #28a745; font-weight: 700; font-size: 1.1rem; }
.card-3d .location { color: #666; font-size: 0.95rem; }
.card-3d .stars { color: #ffc107; font-size: 1.1rem; }
.testimonial-card {
  background: var(--white);
  border-radius: 1.5rem;
  box-shadow: 0 4px 24px #44789222, 0 1.5px 6px #7C9FC0;
  border: none;
  padding: 2rem 1.2rem 1.2rem 1.2rem;
  min-height: 270px;
  display: flex; flex-direction: column; align-items: flex-start;
  transition: box-shadow 0.4s, transform 0.4s;
  animation: rotateIn 1.2s cubic-bezier(.4,2,.3,1);
}
@keyframes rotateIn { from { opacity:0; transform:rotateY(-30deg) scale(0.9);} to {opacity:1;transform:rotateY(0) scale(1);} }
.testimonial-card:hover { box-shadow: 0 16px 48px #44789233, 0 8px 24px #244F7633; transform: rotateY(4deg) scale(1.03); }
.testimonial-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid var(--light-blue); margin-right: 0.8rem; }
.testimonial-name { font-family: 'Inknut Antiqua', serif; color: var(--dark-blue); font-weight: bold; font-size: 1.08em; }
.testimonial-role { color: var(--light-blue); font-size: 0.97em; }
.testimonial-quote { font-size: 2.2rem; color: var(--medium-blue); margin-left: auto; opacity: 0.7; }
.testimonial-content { font-family: 'Poppins', sans-serif; color: #333; font-size: 1.05em; margin-top: 0.5rem; }
.faq-section .faq-question { font-family: 'Inknut Antiqua', serif; color: var(--dark-blue); font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: color 0.3s; }
.faq-section .faq-question:hover { color: var(--medium-blue); }
.faq-section .faq-answer { font-family: 'Poppins', sans-serif; color: #555; display: none; transition: all 0.4s; }
.faq-section .faq-answer.show { display: block; animation: fadeInUp 0.7s; }
@keyframes fadeInUp { from { opacity:0; transform:translateY(30px);} to {opacity:1;transform:translateY(0);} }
@media (max-width: 991px) {
  .section-title { font-size: 2rem; }
  .testimonial-card { min-height: 220px; }
  .stats-glass { min-height: 180px; max-height: 220px; padding: 1.2rem 0.7rem; }
  .stats-glass .fa { font-size: 2rem; }
  .stats-number { font-size: 1.3rem; }
}
</style>



<div class="container py-5">
  <!-- Statistiques (Bilan du Mois) -->
  <h2 class="section-title fade-in-down">Bilan du Mois</h2>
  <div class="row g-4 mb-5 stats-row fade-in-up">
    <div class="col-12 col-md-4">
      <div class="stats-glass">
        <span class="stats-icon"><i class="fa-solid fa-house-chimney"></i></span>
        <div class="stats-title">Réservations reçues</div>
        <div class="stats-value">{{ $totalRequests }} demandes</div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="stats-glass">
        <span class="stats-icon"><i class="fa-solid fa-handshake"></i></span>
        <div class="stats-title">Appartements loués</div>
        <div class="stats-value">{{ $rejectedBookings }} Appartements</div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="stats-glass">
        <span class="stats-icon"><i class="fa-solid fa-envelope"></i></span>
        <div class="stats-title">Messages échangés</div>
        <div class="stats-value">{{ $confirmedBookings }} Appartements</div>
      </div>
    </div>
  </div>

  <!-- Les dernières logements ajoutés -->
  <h2 class="section-title fade-in-left">Les derniers logements ajoutés</h2>
  <div class="row g-4 mb-5 fade-in-up">
    @forelse($latestLogements->take(8) as $annonce)
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-3d h-100">
          @if($annonce->logement && $annonce->logement->photos)
            @php $photos = $annonce->logement->photos; @endphp
            <img src="{{ asset($photos[0] ?? 'images/default.jpg') }}" alt="Logement" class="card-img-top">
          @else
            <img src="{{ asset('images/default.jpg') }}" alt="Logement" class="card-img-top">
          @endif
          <div class="card-body">
            <h3 class="card-title">{{ $annonce->titre_anno }}</h3>
            <div class="price">{{ $annonce->logement->prix_log ?? 0 }} DH / MOIS</div>
            <div class="location">{{ $annonce->logement->localisation_log ?? 'Non spécifié' }}</div>
            <div class="stars">★★★★★</div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <p class="text-center text-muted">Aucun logement disponible pour le moment.</p>
      </div>
    @endforelse
  </div>

  <!-- FAQ -->
  <div class="faq-section fade-in-up mb-5">
    <h2 class="section-title text-center">FAQ</h2>
    <div class="row g-4 text-center">
      <div class="col-12 col-md-6 col-lg-3">
        <div class="faq-item text-center ">
          <div class="faq-question" onclick="toggleAnswer(this)">Qu'est-ce que FindStay ?</div>
          <div class="faq-answer">FindStay est une plateforme qui vous aide à trouver facilement des hébergements de qualité...</div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-3">
        <div class="faq-item text-center">
          <div class="faq-question" onclick="toggleAnswer(this)">Comment créer un compte sur FindStay ?</div>
          <div class="faq-answer">Pour créer un compte, cliquez sur 'S'inscrire' et remplissez le formulaire...</div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-3">
        <div class="faq-item text-center">
          <div class="faq-question" onclick="toggleAnswer(this)">Comment modifier ou annuler une réservation ?</div>
          <div class="faq-answer">Vous pouvez modifier ou annuler une réservation depuis votre profil...</div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-3">
        <div class="faq-item text-center">
          <div class="faq-question" onclick="toggleAnswer(this)">FindStay propose-t-il une application mobile ?</div>
          <div class="faq-answer">Oui, FindStay propose une application mobile disponible sur iOS et Android...</div>
        </div>
      </div>
    </div>
  </div>

  <!-- En quelques chiffres (same as locataire) -->
  <div class="row g-0 align-items-center fade-in-up" style="background: linear-gradient(90deg, #c5d6e1 60%, #fff 100%); border-radius:2rem; overflow:hidden;">
    <div class="col-12 col-md-6 p-4 d-flex flex-column align-items-center justify-content-center position-relative" style="min-height:220px;">
      <img src="{{ asset('images/map.png') }}" alt="Carte du Maroc" class="w-100 h-100 object-cover rounded-3 shadow" style="max-width:340px; filter:brightness(0.95) blur(0.5px);">
      <div class="position-absolute top-50 start-50 translate-middle text-center" style="z-index:2;">
        <div class="display-3 fw-bold text-dark" style="text-shadow:0 2px 8px #fff,0 1px 2px #44789255;">93</div>
        <div class="lead text-dark">Logements Gérés au Maroc</div>
      </div>
      <div class="position-absolute top-0 start-0 w-100 h-100" style="background:linear-gradient(120deg,rgba(124,159,192,0.12) 0%,rgba(68,120,146,0.10) 100%);z-index:1;"></div>
    </div>
    <div class="col-12 col-md-6 p-4">
      <h2 class="section-title mb-4" style="font-size:1.7rem;">En Quelques chiffres</h2>
      <div class="row g-4 text-center">
        <div class="col-6 col-md-6">
          <div class="stats-number" data-count="2000">0</div>
          <div class="stats-label">JEUNES LOGÉS</div>
        </div>
        <div class="col-6 col-md-6">
          <div class="stats-number" data-count="88">0</div>
          <div class="stats-label">Résidences satisfaisantes</div>
        </div>
        <div class="col-6 col-md-6">
          <div class="stats-number" data-count="800">0</div>
          <div class="stats-label">UTILISATEURS ACTIFS</div>
        </div>
        <div class="col-6 col-md-6">
          <div class="stats-number" data-count="90">0</div>
          <div class="stats-label">LOGEMENTS DISPONIBLES</div>
        </div>
      </div>
    </div>
  </div>
</div>

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