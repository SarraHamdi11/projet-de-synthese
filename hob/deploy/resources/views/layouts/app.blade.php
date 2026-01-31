<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php use App\Models\Conversation; @endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FindStay</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background:#fff !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar,
        .navbar-custom,
        .navbar-expand-lg {
            box-shadow: none !important;
        }
        .main-header-bg {
            background: url('/images/image.png') center/cover no-repeat;
            min-height: 220px;
            position: relative;
        }
        .navbar-custom {
            background: transparent !important;
            backdrop-filter: none;
            border-radius: 0;
            position: relative;
            z-index: 2;
        }
        .navbar-brand img {
            height: 150px;
            background: none !important;
            box-shadow: none !important;
            transition: transform 0.3s cubic-bezier(.68,-0.55,.27,1.55);
        }
        .navbar-brand img:hover {
            transform: scale(1.10) rotate(-2deg);
        }
        .navbar-custom .nav-link, .navbar-custom .fa, .navbar-custom .fas, .navbar-custom .far, .navbar-custom .dropdown-toggle {
            color: #244F76 !important;
            font-weight: 600;
            font-size: 1.1rem;
            position: relative;
            transition: color 0.2s;
        }
        .navbar-custom .nav-link::after {
            content: '';
            display: block;
            width: 0;
            height: 2.5px;
            background: #7C9FC0;
            transition: width .3s cubic-bezier(.68,-0.55,.27,1.55);
            position: absolute;
            left: 0; bottom: 0;
            border-radius: 2px;
        }
        .navbar-custom .nav-link:hover::after, .navbar-custom .nav-link.active::after {
            width: 100%;
        }
        .navbar-custom .nav-link.active, .navbar-custom .nav-link:focus, .navbar-custom .nav-link:hover {
            color: #7C9FC0 !important;
        }
        .header-welcome {
            position: absolute;
            left: 50%;
            top: 60%;
            transform: translate(-50%, -50%);
            color: #244F76;
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow: 1px 1px 8px #fff;
            z-index: 2;
            animation: fadeInUp 1.1s cubic-bezier(.68,-0.55,.27,1.55);
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translate(-50%, 30px); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }
        .main-content {
            flex: 1 0 auto;
            padding-bottom: 40px;
        }
        .footer-custom {
            background: #7C9FC0;
            color: #fff;
            padding: 30px 0 10px 0;
            font-size: 1rem;
            border-top: 1px solid #d1dbe6;
        }
        .footer-custom .footer-logo {
            height: 150px;
            margin-bottom: 10px;
            transition: transform 0.3s cubic-bezier(.68,-0.55,.27,1.55);
        }
        .footer-custom .footer-logo:hover {
            transform: scale(1.10) rotate(-2deg);
        }
        .footer-custom a {
            color: #fff;
            text-decoration: underline;
        }
        .footer-custom a:hover {
            color: #244F76;
        }
        .footer-custom .footer-section {
            margin-bottom: 15px;
        }
        .footer-custom .footer-title {
            font-weight: bold;
            margin-bottom: 8px;
        }
        .footer-custom .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-custom .footer-links li {
            margin-bottom: 4px;
        }
        .footer-custom .footer-bottom {
            text-align: center;
            font-size: 0.95rem;
            margin-top: 10px;
            color: #fff;
        }
        .dropdown-menu-messages {
            min-width: 320px;
            max-width: 350px;
        }
        .dropdown-menu-notifications {
            min-width: 350px;
            max-width: 400px;
        }
        .notif-item {
            background: #24507a;
            color: #fff;
            border-radius: 12px;
            margin-bottom: 10px;
            padding: 12px 10px;
            display: flex;
            align-items: center;
        }
        .notif-item .notif-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
        }
        .notif-item .notif-content {
            flex: 1;
        }
        .notif-item .notif-name {
            font-weight: bold;
            font-size: 1rem;
        }
        .notif-item .notif-role {
            background: #e3f2fd;
            color: #24507a;
            border-radius: 8px;
            font-size: 0.8rem;
            padding: 2px 8px;
            margin-left: 8px;
        }
        .notif-item .notif-message {
            font-size: 0.95rem;
        }
        .dropdown-header {
            font-size: 1.1rem;
            font-weight: 600;
            color: #24507a;
        }
        .dropdown-menu-messages .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
        }
        .dropdown-menu-messages .dropdown-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .dropdown-menu-messages .dropdown-item span {
            font-size: 1rem;
            font-weight: 500;
        }
        .dropdown-menu-messages .dropdown-item:not(:last-child) {
            border-bottom: 1px solid #f0f0f0;
        }
        .badge.bg-danger {
            font-size: 0.8rem;
            min-width: 20px;
            min-height: 20px;
        }
        .modal-lg {
            max-width: 700px;
        }
        .modal-content {
            max-height: 80vh;
            overflow: hidden;
        }
        .modal-body {
            max-height: 60vh;
            overflow-y: auto;
        }
        #chatBoxContainer {
            position: fixed;
            top: 80px; /* below navbar */
            right: 0;
            width: 340px;
            height: 500px;
            background: #fff;
            box-shadow: -2px 0 16px rgba(36,80,122,0.12);
            border-top-left-radius: 16px;
            border-bottom-left-radius: 16px;
            z-index: 1055;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s;
        }
        #chatBoxContainer .chat-header {
            background: #24507a;
            color: #fff;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 16px;
            border-top-right-radius: 16px;
            font-size: 16px;
            font-weight: bold;
            justify-content: space-between;
        }
        #chatBoxContainer .chat-header img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 10px;
        }
        #chatBoxContainer .close-chat-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 22px;
            cursor: pointer;
        }
        #chatBoxContainer .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 12px;
            background: #f8f9fa;
        }
        #chatBoxContainer .chat-message {
            max-width: 250px;
            padding: 10px 12px;
            margin-bottom: 10px;
            border-radius: 15px;
            font-size: 14px;
            word-break: break-word;
        }
        #chatBoxContainer .chat-message.sent {
            background: #24507a;
            color: #fff;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }
        #chatBoxContainer .chat-message.received {
            background: #e9ecef;
            color: #222;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }
        #chatBoxContainer .message-time {
            font-size: 0.75em;
            color: #888;
            margin-top: 2px;
            text-align: right;
        }
        #chatBoxContainer .chat-footer {
            height: 50px;
            padding: 8px 10px;
            background: #fff;
            border-top: 1px solid #eee;
            display: flex;
            align-items: center;
            border-bottom-right-radius: 16px;
        }
        #chatBoxContainer .chat-footer .input-group {
            width: 100%;
        }
        #chatBoxContainer .chat-footer input {
            font-size: 14px;
        }
        #chatBoxContainer .chat-footer button {
            font-size: 20px;
        }
        /* Ensure dropdown icons and toggles are always #244F76 */
        .navbar-custom .dropdown-toggle::after {
            color: #244F76 !important;
        }
        .navbar-custom .dropdown-menu {
            min-width: 320px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(36,79,118,0.08);
            border: 1px solid #eaf1f7;
        }
        .navbar-custom .dropdown-menu .dropdown-header {
            color: #244F76;
        }
        .navbar-custom .dropdown-item {
            color: #244F76;
        }
        .navbar-custom .dropdown-item:hover, .navbar-custom .dropdown-item:focus {
            background: #eaf1f7;
            color: #244F76;
        }
        /* Icon animations */
        .navbar-custom .fa-cog:hover {
            animation: spinCog 0.7s cubic-bezier(.68,-0.55,.27,1.55);
        }
        @keyframes spinCog {
            0% { transform: rotate(0deg); }
            60% { transform: rotate(180deg); }
            100% { transform: rotate(360deg); }
        }
        .navbar-custom .fa-bell[data-has-unread="true"] {
            animation: bellPulse 1.2s infinite alternate;
        }
        @keyframes bellPulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.15) rotate(-8deg); }
        }
        .mark-read-btn {
            background: #fff !important;
            color: #244F76 !important;
            border: 1.5px solid #244F76 !important;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, color 0.2s;
        }
        .mark-read-btn i {
            color: #244F76 !important;
        }
        .mark-read-btn:hover {
            background: #244F76 !important;
            color: #fff !important;
        }
        .mark-read-btn:hover i {
            color: #fff !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="main-header-bg">
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="/images/findStay-removebg-preview.png" alt="Findstay Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.accueilproprietaire') : route('locataire.accueillocataire') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.logements') : route('logementsloca') }}">Nos logements</a>
                        </li>
                        <li class="nav-item">

                            <a class="nav-link" href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.reservations.index') : route('locataire.reservations.index') }}">Mes réservations</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.annoncesproprietaire.index') : route('locataire.annonceslocataire.index') }}">Mes annonces</a>
                        </li>
                        @if(auth()->user()->role_uti === 'locataire')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('locataire.favorites') }}">Mes favoris</a>
                        </li>
                        @endif
                    </ul>
                    <div class="d-flex align-items-center gap-3 ms-auto">
                        <!-- Chat Icon -->
                        <div class="dropdown">
                            <a href="#" id="chatDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="position-relative dropdown-toggle">
                                <i class="fas fa-comments fa-lg"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-white text-primary" style="color: #24507a !important; background: #fff !important; border: 2px solid #24507a !important; min-width: 28px; min-height: 28px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1rem;">
                                    {{ auth()->user()->receivedMessages()->where('is_read', false)->count() ?: 0 }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-messages p-3" aria-labelledby="chatDropdown">
                                <h6 class="dropdown-header">Conversations</h6>
                                <div style="max-height: 300px; overflow-y: auto;">
                                    @foreach (App\Models\Conversation::where('expediteur_id', auth()->id())->orWhere('destinataire_id', auth()->id())->with(['expediteur', 'destinataire'])->latest('date_debut_conv')->get() as $conv)
                                        @php
                                            $otherUser = ($conv->expediteur_id === auth()->id()) ? $conv->destinataire : $conv->expediteur;
                                        @endphp
                                        <li class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                                <a class="dropdown-item d-flex align-items-center gap-2 flex-grow-1 open-conversation-link" href="#" data-conversation-id="{{ $conv->id }}">
                                                    <img src="{{ $otherUser->photodeprofil_uti ? asset('storage/' . $otherUser->photodeprofil_uti) : asset('images/default-avatar.png') }}" alt="{{ $otherUser->prenom }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                    <span>{{ $otherUser->prenom }} {{ $otherUser->nom_uti }}</span>
                                                </a>
                                            </div>
                                            <button type="button" class="btn btn-link text-danger p-0 ms-2 delete-conversation-btn" data-conversation-id="{{ $conv->id }}" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </li>
                                    @endforeach
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('conversations.index') }}" class="dropdown-item text-center">Voir tous les messages</a>
                            </ul>
                        </div>
                        <!-- Notification Icon -->
                        <div class="dropdown">
                            <a href="#" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="position-relative dropdown-toggle">
                                <i class="fas fa-bell fa-lg"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-white text-primary" style="color: #24507a !important; background: #fff !important; border: 2px solid #24507a !important; min-width: 28px; min-height: 28px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1rem;">
                                    {{ auth()->user()->notifications()->whereNull('read_at')->count() ?: 0 }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-notifications p-3" aria-labelledby="notifDropdown">
                                <h6 class="dropdown-header">Notifications</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="{{ route('notifications.index') }}" class="dropdown-item text-center p-0" style="flex:1;">Voir toutes les notifications</a>
                                    <button id="deleteAllNotificationsBtn" class="btn btn-link text-danger p-0 ms-2" style="white-space:nowrap;">Supprimer toutes</button>
                                </div>
                                <div style="max-height: 300px; overflow-y: auto;" id="notifListContainer">
                                    @forelse(auth()->user()->notifications()->whereNull('read_at')->get() as $notification)
                                        <div class="notif-item d-flex align-items-center justify-content-between" data-notification-id="{{ $notification->id }}">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $notification->data['avatar'] ?? asset('images/default-avatar.png') }}" class="notif-avatar" alt="avatar" style="background: #fff;">
                                                <div class="notif-content">
                                                    <div class="notif-name">
                                                        {{ $notification->data['name'] ?? 'Utilisateur' }}
                                                    </div>
                                                    <div class="notif-message">
                                                        @if(isset($notification->data['type']) && $notification->data['type'] === 'reservation')
                                                            demande de reservation
                                                        @elseif(isset($notification->data['type']) && $notification->data['type'] === 'comment')
                                                            {{ $notification->data['name'] ?? 'Utilisateur' }} a commenté votre poste
                                                        @elseif(isset($notification->data['type']) && $notification->data['type'] === 'reservation_status')
                                                            {{ $notification->data['message'] ?? '' }}
                                                        @else
                                                            {{ $notification->data['message'] ?? $notification->data['body'] ?? '' }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!$notification->read_at)
                                                <button class="btn btn-sm btn-outline-primary mark-read-btn" onclick="markAsRead('{{ $notification->id }}', this)">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @empty
                                        <span class="dropdown-item text-muted">Aucune notification</span>
                                    @endforelse
                                </div>
                            </ul>
                        </div>
                        <!-- Profile Picture Icon -->
                        <div class="ms-2">
                            <a href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.myprofile') : route('locataire.myprofile') }}">
                                <img src="{{ auth()->user()->photodeprofil_uti ? asset('storage/' . auth()->user()->photodeprofil_uti) : asset('images/default-avatar.png') }}" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #24507a;">
                            </a>
                        </div>
                        <!-- Settings Icon Dropdown -->
                        <div class="dropdown ms-2">
                            <a href="#" id="settingsDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-link p-0 dropdown-toggle d-flex align-items-center" style="box-shadow:none;">
                                
                                <i class="fas fa-cog fa-lg"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Modifier le profil</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.password.form') }}">Changer le mot de passe</a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('profile.delete.form') }}">Supprimer le compte</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Déconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="header-welcome">
            @yield('header')
        </div>
        <div class="text-center mb-10 text-4xl font-bold" style="font-family: 'Inknut Antiqua', serif; color: #244F76; text-shadow: 1px 1px 6px rgba(36, 79, 118, 0.3); padding: 15px 0;">
            @php
                $hour = now()->hour;
                $greeting = $hour < 12 ? 'Bonjour' : ($hour < 18 ? 'Bon après-midi' : 'Bonsoir');
            @endphp
            <span>{{ $greeting }},</span> 
            <span>{{ Auth::user()->prenom }} {{ Auth::user()->nom_uti }}</span> 
        </div>
    </div>
    <main class="main-content container">
        @yield('content')
    </main>
    <footer class="footer-custom mt-auto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 text-center text-md-start footer-section">
                    <img src="/images/findStay-removebg-preview.png" alt="Findstay Logo" class="footer-logo">
                    <div>Trouvez votre chez-vous avec FindStay. Facile, rapide, fiable</div>
                </div>
                <div class="col-md-3 text-center footer-section">
                    <div class="footer-title">Nos Services</div>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">On Quelques chiffres</a></li>
                    </ul>
                </div>
                <div class="col-md-3 text-center footer-section">
                    <div class="footer-title">Contact</div>
                    <div>FindStay@gmail.com</div>
                </div>
                <div class="col-md-3 text-center footer-section">
                    <div class="footer-title">Navigation</div>
                    <ul class="footer-links">
                        <li><a href="/">Accueil</a></li>
                        <li><a href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.logements') : route('logementsloca') }}">Nos logements</a></li>
                        <li><a href="#">Mes réservations</a></li>
                        <li><a href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.annoncesproprietaire.index') : route('locataire.annonceslocataire.index') }}">Mes annonces</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom mt-3">
                © 2025 FindStay. Tous droits réservés.
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <div id="chatBoxContainer" style="display:none;"></div>
    <script>
        function attachCloseChatHandler() {
            const chatBox = document.getElementById('chatBoxContainer');
            const btn = chatBox.querySelector('.close-chat-btn');
            if (btn) {
                btn.onclick = () => { chatBox.style.display = "none"; };
            }
        }
        (function() {
            const chatBox = document.getElementById("chatBoxContainer");
            document.addEventListener('click', function(e) {
                // Open conversation only if clicking the .open-conversation-link
                const openLink = e.target.closest('.open-conversation-link');
                if (openLink) {
                    e.preventDefault();
                    const convId = openLink.getAttribute("data-conversation-id");
                    chatBox.innerHTML = "<div class='text-center p-5'><div class='spinner-border' role='status'><span class='visually-hidden'>Loading…</span></div></div>";
                    chatBox.style.display = "flex";
                    fetch(`/conversations/view/${convId}`, { headers: { "Accept": "application/json" } })
                        .then(resp => resp.text())
                        .then(html => { chatBox.innerHTML = html; attachCloseChatHandler(); })
                        .catch(err => { chatBox.innerHTML = '<p class=\"text-danger\">Erreur de chargement de la conversation.</p>'; });
                }
            });
            attachCloseChatHandler();
        })();
    </script>
    <script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.delete-conversation-btn');
        if (btn) {
            e.preventDefault();
            e.stopImmediatePropagation();
            const convId = btn.getAttribute('data-conversation-id');
            if (confirm('Voulez-vous vraiment supprimer cette conversation ?')) {
                fetch(`/conversations/${convId}/delete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(resp => resp.json())
                .then(data => {
                    if (data.success) {
                        btn.closest('li').remove();
                    }
                });
            }
            return false;
        }
    });
    </script>
    <script>
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'message-form-modal') {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const chatBox = document.getElementById('chatBoxContainer');
            fetch('/messages/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.success && data.conversation_id) {
                    // Reload the conversation via AJAX
                    fetch(`/conversations/view/${data.conversation_id}`, { headers: { "Accept": "application/json" } })
                        .then(resp => resp.text())
                        .then(html => { chatBox.innerHTML = html; attachCloseChatHandler(); })
                } else {
                    let msg = 'Erreur lors de l\'envoi du message.';
                    if (data && data.error) msg += '\n' + data.error;
                    alert(msg);
                }
            })
            .catch(async (err) => {
                let msg = 'Erreur lors de l\'envoi du message.';
                if (err.response) {
                    const data = await err.response.json();
                    if (data && data.error) msg += '\n' + data.error;
                }
                alert(msg);
            });
        }
    });
    </script>
    <script>
    document.getElementById('deleteAllNotificationsBtn')?.addEventListener('click', function() {
        if (confirm('Voulez-vous vraiment supprimer toutes les notifications ?')) {
            fetch('/notifications/delete-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('notifListContainer').innerHTML = '<span class="dropdown-item text-muted">Aucune notification</span>';
                }
            });
        }
    });
    </script>
    <script>
    function markAsRead(notificationId, btn) {
        fetch(`/notifications/${notificationId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                btn.remove();
                // Update the unread count in the navbar
                const unreadCountElement = document.querySelector('.fa-bell + .badge, #unread-notifications-count');
                if (unreadCountElement) {
                    let currentCount = parseInt(unreadCountElement.textContent);
                    if (currentCount > 0) {
                        unreadCountElement.textContent = currentCount - 1;
                        if (currentCount - 1 === 0) {
                            unreadCountElement.style.display = 'none';
                        }
                    }
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>
</body>
</html>