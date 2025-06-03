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
  min-width: 220px;
  max-width: 260px;
  flex: 0 0 220px;
  background: #fff;
  border-radius: 1.2rem;
  box-shadow: 0 2px 12px rgba(36,79,118,0.08), 0 1.5px 6px #7C9FC022;
  border: 1px solid #e6e6e6;
  margin-bottom: 1.2rem;
  transition: box-shadow 0.3s, transform 0.3s, border 0.3s;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  padding: 1.2rem 1rem 1.2rem 1rem;
}
.testimonial-card:hover {
  box-shadow: 0 8px 32px rgba(36,79,118,0.16), 0 4px 16px #44789233;
  transform: translateY(-6px) scale(1.03);
  border: 1.5px solid #44789233;
  z-index: 2;
}
.testimonial-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #7C9FC0;
  margin-right: 0.8rem;
}
.testimonial-name {
  font-family: 'Inknut Antiqua', serif;
  color: #244F76;
  font-weight: bold;
  font-size: 1.08em;
}
.testimonial-role {
  color: #7C9FC0;
  font-size: 0.97em;
}
.testimonial-quote {
  font-size: 2.2rem;
  color: #447892;
  margin-left: auto;
  opacity: 0.7;
}
.testimonial-content {
  font-family: 'Poppins', sans-serif;
  color: #333;
  font-size: 1.05em;
  margin-top: 0.5rem;
}
.testimonial-card .rating {
  margin-top: 0.3rem;
}
@media (max-width: 1200px) {
  .testimonial-card { min-width: 180px; max-width: 200px; flex: 0 0 180px; }
}
@media (max-width: 768px) {
  .testimonial-card { min-width: 80vw; max-width: 80vw; flex: 0 0 80vw; }
}
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

/* Uniformisation des cards par section (hauteur adaptée à chaque section) */
.stats-glass {
  min-height: 220px;
  max-height: 260px;
  padding: 2rem 1.5rem;
  border-radius: 2rem;
  text-align: center;
  color: #447892;
}
.stats-glass .fa {
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
}
.stats-number {
  font-size: 2rem;
  margin-bottom: 0.2rem;
}
.stats-label {
  font-size: 1.05rem;
}
.card-3d {
  min-height: 320px;
}
.faq-item {
  min-height: 180px;
}
.testimonial-card {
  min-height: 270px;
}

/* Témoignages - carrousel horizontal */
.testimonials-carousel-wrapper {
  position: relative;
  overflow: hidden;
  padding: 0 60px;
  margin-bottom: 3rem;
  background: linear-gradient(120deg, #f7fafc 80%, #e3eaf3 100%);
  border-radius: 1.7rem;
  box-shadow: 0 8px 32px rgba(36,79,118,0.10), 0 2px 8px #44789222;
  padding-top: 2.2rem;
  padding-bottom: 2.7rem;
  margin-top: 2.5rem;
  min-height: 340px;
  display: flex;
  align-items: center;
}
.testimonials-carousel {
  display: flex;
  gap: 24px;
  transition: transform 0.9s cubic-bezier(.4,2,.3,1);
  margin: 0;
  padding: 0;
}
.testimonial-card {
  min-width: 320px;
  flex: 0 0 320px;
  background: white;
  border-radius: 1rem;
  padding: 1.5rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  transition: transform 0.3s ease;
}
.testimonial-card:hover {
  transform: translateY(-5px);
}
.testimonials-carousel-controls {
  position: absolute;
  top: 50%;
  left: 1.5rem;
  right: 1.5rem;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  pointer-events: none;
  z-index: 3;
}
.carousel-control {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: #fff;
  border: none;
  color: #244F76;
  font-size: 1.7rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
  pointer-events: all;
  box-shadow: 0 2px 12px #44789222;
  opacity: 0.92;
}
.carousel-control:hover {
  background: #244F76;
  color: #fff;
  box-shadow: 0 6px 24px #44789233;
  transform: scale(1.08);
  opacity: 1;
}
.carousel-control.prev { margin-left: -20px; }
.carousel-control.next { margin-right: -20px; }
@media (max-width: 1200px) {
  .testimonials-carousel-wrapper { padding: 0 30px; }
  .testimonials-carousel-controls { left: 0.5rem; right: 0.5rem; }
}
@media (max-width: 768px) {
  .testimonials-carousel-wrapper { padding: 0 10px; }
  .testimonials-carousel-controls { left: 0.1rem; right: 0.1rem; }
}

/* Les derniers logements ajoutés */
.logements-carousel-wrapper {
  overflow: hidden;
  position: relative;
  width: 100%;
  background: linear-gradient(120deg, #f7fafc 80%, #e3eaf3 100%);
  border-radius: 1.7rem;
  box-shadow: 0 8px 32px rgba(36,79,118,0.10), 0 2px 8px #44789222;
  padding: 2.2rem 1.5rem 2.7rem 1.5rem;
  margin-bottom: 3.5rem;
  margin-top: 2.5rem;
  min-height: 340px;
  display: flex;
  align-items: center;
}
.logements-carousel {
  display: flex;
  transition: transform 0.9s cubic-bezier(.4,2,.3,1);
  will-change: transform;
  gap: 1.2rem;
}
.carousel-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 3;
  background: #fff;
  border: none;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  font-size: 1.7rem;
  color: #244F76;
  box-shadow: 0 2px 12px #44789222;
  transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
  pointer-events: all;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0.92;
}
.carousel-arrow.left { left: 0.7rem; }
.carousel-arrow.right { right: 0.7rem; }
.carousel-arrow:hover {
  background: #244F76;
  color: #fff;
  box-shadow: 0 6px 24px #44789233;
  transform: translateY(-50%) scale(1.08);
  opacity: 1;
}
.logement-card {
  min-width: 260px;
  max-width: 280px;
  flex: 0 0 260px;
  background: #fff;
  border-radius: 1.2rem;
  box-shadow: 0 2px 12px rgba(36,79,118,0.08), 0 1.5px 6px #7C9FC022;
  border: 1px solid #e6e6e6;
  margin-bottom: 1.2rem;
  transition: box-shadow 0.3s, transform 0.3s, border 0.3s;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}
.logement-card:hover {
  box-shadow: 0 8px 32px rgba(36,79,118,0.16), 0 4px 16px #44789233;
  transform: translateY(-6px) scale(1.03);
  border: 1.5px solid #44789233;
  z-index: 2;
}
.logement-card .card-img-top {
  height: 150px;
  object-fit: cover;
  border-top-left-radius: 1.2rem;
  border-top-right-radius: 1.2rem;
}
.logement-card .card-body {
  padding: 1rem 1.1rem 1.2rem 1.1rem;
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
}
.logement-card .card-title {
  font-size: 1.08rem;
  font-weight: 700;
  color: #244F76;
  margin-bottom: 0.2rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.logement-card .price {
  color: #28a745;
  font-weight: 700;
  font-size: 1.05rem;
  margin-bottom: 0.1rem;
}
.logement-card .location {
  color: #666;
  font-size: 0.97rem;
  margin-bottom: 0.1rem;
}
.logement-card .stars {
  color: #ffc107;
  font-size: 1.05rem;
  margin-bottom: 0.2rem;
}
.logement-card .btn {
  background: #244F76;
  border: none;
  font-weight: 600;
  margin-top: 0.5rem;
  border-radius: 0.7rem;
  transition: background 0.2s, box-shadow 0.2s;
  cursor: pointer;
  box-shadow: 0 2px 8px #44789222;
}
.logement-card .btn:hover {
  background: #447892;
  box-shadow: 0 4px 16px #44789233;
}
@media (max-width: 1200px) {
  .logements-carousel-wrapper { padding: 1.2rem 0.2rem 1.7rem 0.2rem; }
  .carousel-arrow { width: 40px; height: 40px; font-size: 1.2rem; }
}
@media (max-width: 768px) {
  .logements-carousel-wrapper { padding: 0.7rem 0.1rem 1.2rem 0.1rem; min-height: 220px; }
  .carousel-arrow { width: 36px; height: 36px; font-size: 1rem; }
}
</style>

<div class="container py-5">
  <!-- Statistiques -->
  <h2 class="section-title fade-in-down">Activité de vos réservations</h2>
  <div class="row g-4 mb-5 stats-row fade-in-up">
    <div class="col-12 col-md-3">
      <div class="stats-glass">
        <span class="stats-icon"><i class="fa-solid fa-house-chimney"></i></span>
        <div class="stats-title">Nombre de mes réservations</div>
        <div class="stats-value">25 demandes</div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="stats-glass">
        <span class="stats-icon"><i class="fa-solid fa-handshake"></i></span>
        <div class="stats-title">Réservations confirmées</div>
        <div class="stats-value">12 Appartements</div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="stats-glass">
        <span class="stats-icon"><i class="fa-solid fa-handshake"></i></span>
        <div class="stats-title">Réservations refusées</div>
        <div class="stats-value">8 Appartement</div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="stats-glass">
        <span class="stats-icon"><i class="fa-solid fa-handshake"></i></span>
        <div class="stats-title">Réservations terminées</div>
        <div class="stats-value">128 messages</div>
      </div>
    </div>
  </div>
  <!-- Les derniers logements ajoutés -->
  <h2 class="section-title fade-in-left">Les derniers logements ajoutés</h2>
  <div class="logements-carousel-wrapper position-relative mb-5 fade-in-up">
    <button class="carousel-arrow left" onclick="slideLogements(-1)"><i class="fa fa-chevron-left"></i></button>
    <div class="logements-carousel d-flex" id="logementsCarousel">
    @forelse($latestAnnonces as $annonce)
        <div class="logement-card card card-3d h-100 me-3">
          @if($annonce->logement && $annonce->logement->photos)
            @php $photos = is_array($annonce->logement->photos) ? $annonce->logement->photos : json_decode($annonce->logement->photos, true); @endphp
            <img src="{{ asset($photos[0] ?? 'images/default.jpg') }}" alt="Logement" class="card-img-top">
          @else
            <img src="{{ asset('images/default.jpg') }}" alt="Logement" class="card-img-top">
          @endif
          <div class="card-body" style="padding: 1.2rem 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
            <h3 class="card-title" style="margin-bottom: 0.4rem;">{{ $annonce->titre_anno ?? 'Logement' }}</h3>
            <div class="price" style="margin-bottom: 0.3rem;">{{ number_format($annonce->logement->prix_log ?? 0, 0, ',', ' ') }} DH / MOIS</div>
            <div class="location" style="margin-bottom: 0.3rem;">{{ $annonce->logement->localisation_log ?? 'Non spécifié' }}</div>
            <div class="stars" style="margin-bottom: 0.5rem;">★★★★★</div>
            <a href="{{ route('showDetails', $annonce->logement->id) }}" class="btn btn-primary mt-2 w-100" style="background: #244F76; border: none; font-weight: 600; margin-top: 0.7rem;">Détails</a>
        </div>
      </div>
    @empty
      <div class="col-12">
        <p class="text-center text-muted">Aucun logement disponible pour le moment.</p>
      </div>
    @endforelse
    </div>
    <button class="carousel-arrow right" onclick="slideLogements(1)"><i class="fa fa-chevron-right"></i></button>
  </div>
  <!-- Témoignages - Carrousel horizontal -->
  <h2 class="section-title fade-in-right">Ce que nos clients nous disent</h2>
  <div class="testimonials-carousel-wrapper">
    <div class="testimonials-carousel" id="testimonialsCarousel">
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Yassine El Amrani</div>
            <div class="testimonial-role">Étudiant à Rabat</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"Grâce à FindStay, j'ai trouvé un studio à deux pas de mon université. Plateforme fiable et propriétaires sérieux !"</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Salma Benali</div>
            <div class="testimonial-role">Jeune active à Casablanca</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"J'ai adoré la simplicité d'utilisation du site. J'ai pu visiter plusieurs appartements en toute sécurité."</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
      </div>
        <div class="testimonial-card">
          <div class="d-flex align-items-center mb-2">
            <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="avatar" class="testimonial-avatar">
            <div>
            <div class="testimonial-name">Othmane Idrissi</div>
            <div class="testimonial-role">Doctorant à Fès</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"Service client très réactif, j'ai eu toutes les réponses à mes questions rapidement. Je recommande !"</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Imane Chafai</div>
            <div class="testimonial-role">Étudiante à Marrakech</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"J'ai trouvé un appartement moderne et bien situé. Merci à toute l'équipe FindStay !"</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/men/36.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Hamza Bouzid</div>
            <div class="testimonial-role">Ingénieur à Tanger</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"La réservation en ligne est très pratique. J'ai pu emménager rapidement sans stress."</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/women/50.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Nisrine El Fassi</div>
            <div class="testimonial-role">Étudiante à Agadir</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"J'ai apprécié la transparence des annonces et la sécurité des paiements."</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/men/60.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Anas El Alaoui</div>
            <div class="testimonial-role">Étudiant à Oujda</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"Site très intuitif, j'ai trouvé un logement en quelques clics seulement."</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/women/77.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Fatima Zahra Kabbaj</div>
            <div class="testimonial-role">Jeune diplômée à Meknès</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"J'ai pu comparer plusieurs offres et choisir celle qui me convenait le mieux. Merci FindStay !"</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/men/70.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Mohamed El Idrissi</div>
            <div class="testimonial-role">Étudiant à Settat</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"Plateforme très pratique, je la recommande à tous mes amis !"</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/women/80.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Rania Berrada</div>
            <div class="testimonial-role">Étudiante à El Jadida</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"J'ai trouvé un logement rapidement et sans mauvaise surprise. Merci !"</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
            </div>
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/men/81.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Zakaria El Ghazali</div>
            <div class="testimonial-role">Étudiant à Safi</div>
          </div>
          <div class="testimonial-quote">"</div>
          </div>
          <div class="testimonial-content">
          <p class="testimonial-text">"Le site est bien fait, les annonces sont claires et détaillées. Je recommande vivement !"</p>
                <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                </div>
              </div>
            </div>
      <div class="testimonial-card">
        <div class="d-flex align-items-center mb-2">
          <img src="https://randomuser.me/api/portraits/women/90.jpg" alt="avatar" class="testimonial-avatar">
          <div>
            <div class="testimonial-name">Soukaina El Mansouri</div>
            <div class="testimonial-role">Étudiante à Kénitra</div>
          </div>
          <div class="testimonial-quote">"</div>
        </div>
        <div class="testimonial-content">
          <p class="testimonial-text">"J'ai été rassurée par la sécurité des paiements et la rapidité du service."</p>
          <div class="rating">
            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="testimonials-carousel-controls">
      <button class="carousel-control prev" onclick="slideTestimonials(-1)"><i class="fas fa-chevron-left"></i></button>
      <button class="carousel-control next" onclick="slideTestimonials(1)"><i class="fas fa-chevron-right"></i></button>
    </div>
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
<!-- En quelques chiffres -->
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
// Animation au scroll
function revealOnScroll() {
  document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
    const rect = el.getBoundingClientRect();
    if(rect.top < window.innerHeight - 60) el.classList.add('visible');
  });
}
document.addEventListener('scroll', revealOnScroll);
document.addEventListener('DOMContentLoaded', revealOnScroll);
// Animation des compteurs
function animateCounters() {
  document.querySelectorAll('.stats-number[data-count]').forEach(el => {
    const target = +el.getAttribute('data-count');
    let count = 0;
    const duration = 1200;
    const step = Math.max(1, Math.floor(target / (duration/16)));
    function update() {
      count += step;
      if(count >= target) { el.textContent = target; return; }
      el.textContent = count;
      requestAnimationFrame(update);
    }
    update();
  });
}
document.addEventListener('DOMContentLoaded', animateCounters);
// FAQ toggle
    function toggleAnswer(element) {
        const answer = element.nextElementSibling;
        const allAnswers = document.querySelectorAll('.faq-answer');
        const allQuestions = document.querySelectorAll('.faq-question');
  allAnswers.forEach(ans => { if(ans !== answer) ans.classList.remove('show'); });
  allQuestions.forEach(q => { q.classList.remove('text-blue-600'); });
  if(answer.classList.contains('show')) {
    answer.classList.remove('show');
            element.classList.remove('text-blue-600');
        } else {
    answer.classList.add('show');
            element.classList.add('text-blue-600');
        }
    }

let testimonialIndex = 0;
const testimonialCards = document.querySelectorAll('.testimonial-card');
const cardWidth = testimonialCards[0].offsetWidth + 24; // card width + gap

function slideTestimonials(direction) {
  const maxIndex = testimonialCards.length - 3; // Show 3 cards at once
  testimonialIndex = Math.max(0, Math.min(maxIndex, testimonialIndex + direction));
  
  const carousel = document.getElementById('testimonialsCarousel');
  carousel.style.transform = `translateX(-${testimonialIndex * cardWidth}px)`;
}

// Auto-slide every 5 seconds
let autoSlideInterval = setInterval(() => slideTestimonials(1), 5000);

// Pause auto-slide on hover
const carouselWrapper = document.querySelector('.testimonials-carousel-wrapper');
carouselWrapper.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
carouselWrapper.addEventListener('mouseleave', () => {
  autoSlideInterval = setInterval(() => slideTestimonials(1), 5000);
});

let logementIndex = 0;
function visibleLogementCards() {
  if(window.innerWidth < 600) return 1;
  if(window.innerWidth < 900) return 2;
  if(window.innerWidth < 1200) return 3;
  return 4;
}
function slideLogements(dir) {
  const carousel = document.getElementById('logementsCarousel');
  const cards = carousel.querySelectorAll('.logement-card');
  const maxIndex = Math.max(0, cards.length - visibleLogementCards());
  logementIndex += dir;
  if(logementIndex < 0) logementIndex = 0;
  if(logementIndex > maxIndex) logementIndex = maxIndex;
  carousel.style.transform = `translateX(-${logementIndex * (cards[0].offsetWidth + 24)}px)`;
}
window.addEventListener('resize', () => {
  const carousel = document.getElementById('logementsCarousel');
  const cards = carousel.querySelectorAll('.logement-card');
  carousel.style.transition = 'none';
  carousel.style.transform = `translateX(-${logementIndex * (cards[0].offsetWidth + 24)}px)`;
  setTimeout(()=>carousel.style.transition = '', 100);
});
</script>
@endsection