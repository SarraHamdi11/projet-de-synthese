<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php use App\Models\Conversation; @endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center">
                <img src="/images/findStay-removebg-preview.png" alt="Findstay Logo" style="height:32px; margin-right:8px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        @if(auth()->user()->role_uti === 'proprietaire')
                            <a class="nav-link" href="{{ route('proprietaire.accueilproprietaire') }}">Accueil</a>
                        @else
                            <a class="nav-link" href="{{ route('locataire.accueillocataire') }}">Accueil</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if(auth()->user()->role_uti === 'proprietaire')
                            <a class="nav-link" href="{{ route('proprietaire.logements') }}">Nos logements</a>
                        @else
                            <a class="nav-link" href="{{ route('logementsloca') }}">Nos logements</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <span class="nav-link disabled">Mes réservations</span>
                    </li>
                    <li class="nav-item">
                        @if(auth()->user()->role_uti === 'proprietaire')
                            <a class="nav-link" href="{{ route('proprietaire.annoncesproprietaire.index') }}">Mes annonces</a>
                        @else
                            <a class="nav-link" href="{{ route('locataire.annonceslocataire.index') }}">Mes annonces</a>
                        @endif
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
                        <a href="#" id="chatDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="position-relative">
                            <i class="fas fa-comments fa-lg"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ auth()->user()->receivedMessages()->where('is_read', false)->count() }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-messages p-3" aria-labelledby="chatDropdown">
                            <h6 class="dropdown-header">Conversations</h6>
                            <div style="max-height: 300px; overflow-y: auto;">
                                @foreach (Conversation::where("expediteur_id", auth()->id())->orWhere("destinataire_id", auth()->id())->with(["expediteur", "destinataire"])->latest("date_debut_conv")->get() as $conv)
                                    @php
                                        $otherUser = ($conv->expediteur_id === auth()->id()) ? $conv->destinataire : $conv->expediteur;
                                    @endphp
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2 flex-grow-1">
                                            <a class="dropdown-item d-flex align-items-center gap-2 flex-grow-1 open-conversation-link" href="#" data-conversation-id="{{ $conv->id }}">
                                                <img src="{{ $otherUser->photodeprofil_uti ?? asset('images/default-avatar.png') }}" alt="{{ $otherUser->prenom }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
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
                    <!-- Notifications Icon -->
                    <div class="dropdown">
                        <a href="#" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="position-relative">
                            <i class="fas fa-bell fa-lg"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ auth()->user()->notifications()->whereNull('read_at')->count() }}
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
                                    <div class="notif-item">
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
                                @empty
                                    <span class="dropdown-item text-muted">Aucune notification</span>
                                @endforelse
                            </div>
                        </ul>
                    </div>
                    <!-- Settings Icon and Profile Picture Grouped -->
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ auth()->user()->photodeprofil_uti ? asset('storage/' . auth()->user()->photodeprofil_uti) : asset('images/default-avatar.png') }}" class="rounded-circle" width="40" height="40" alt="profile">
                        <div class="dropdown">
                            <a href="#" id="settingsDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-link p-0"><i class="fas fa-cog fa-lg"></i></a>
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
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <!-- Conversation Chat Box: fixed to the left, content loaded via AJAX from _modal.blade.php -->
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
</body>
</html>