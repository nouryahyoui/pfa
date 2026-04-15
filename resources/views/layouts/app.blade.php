<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme Annonces</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --accent: #0f3460;
            --highlight: #e94560;
        }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(135deg, var(--primary), var(--accent)) !important; box-shadow: 0 2px 20px rgba(0,0,0,0.3); }
        .navbar-brand { font-size: 1.5rem; color: #fff !important; }
        .nav-link { color: rgba(255,255,255,0.85) !important; transition: color 0.3s; }
        .nav-link:hover { color: var(--highlight) !important; }
        .btn-publish { background: var(--highlight); color: white; border: none; border-radius: 25px; padding: 8px 20px; transition: all 0.3s; text-decoration: none; display: inline-block; }
        .btn-publish:hover { background: #c73652; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(233,69,96,0.4); color: white; }
        .card { border: none; border-radius: 15px; transition: all 0.3s ease; overflow: hidden; }
        .card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important; }
        .card-img-top { transition: transform 0.5s ease; }
        .card:hover .card-img-top { transform: scale(1.05); }
        .badge { border-radius: 20px; padding: 6px 12px; }
        .search-section { background: linear-gradient(135deg, var(--primary), var(--accent)); padding: 20px; border-radius: 15px; margin-bottom: 30px; }
        .search-section .form-control, .search-section .form-select { border-radius: 10px; border: none; padding: 12px; }
        .btn-search { background: var(--highlight); color: white; border: none; border-radius: 10px; padding: 12px; transition: all 0.3s; width: 100%; }
        .btn-search:hover { background: #c73652; transform: translateY(-2px); color: white; }
        .alert { border-radius: 10px; border: none; }
        footer { background: linear-gradient(135deg, var(--primary), var(--accent)); color: rgba(255,255,255,0.8); padding: 20px 0; margin-top: 60px; }
        .page-title { font-weight: 700; color: var(--primary); position: relative; padding-bottom: 10px; }
        .page-title::after { content: ''; position: absolute; bottom: 0; left: 0; width: 50px; height: 3px; background: var(--highlight); border-radius: 3px; }
        .dropdown-menu { border-radius: 10px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        nav.flex { justify-content: center !important; }
        nav.flex > div:first-child { display: none !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="bi bi-megaphone-fill"></i> Annonces
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('annonces.index') }}">
                        <i class="bi bi-grid"></i> Annonces
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                @auth
                    <li class="nav-item">
                        <a class="btn btn-publish" href="{{ route('annonces.create') }}">
                            <i class="bi bi-plus-circle"></i> Publier
                        </a>
                    </li>
                    @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Admin
                        </a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('notifications.index') }}">
                                    <i class="bi bi-bell"></i> Notifications
                                    @php
                                        $unread = \App\Models\Notification::where('user_id', auth()->id())
                                                    ->where('lu', false)->count();
                                    @endphp
                                    @if($unread > 0)
                                        <span class="badge bg-danger rounded-pill ms-1">{{ $unread }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('messages.index') }}">
                                    <i class="bi bi-chat-dots"></i> Mes messages
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('annonces.mesAnnonces') }}">
                                    <i class="bi bi-megaphone"></i> Mes annonces
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-publish" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Inscription
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" data-aos="fade-down">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @yield('content')
</div>

<footer class="text-center">
    <div class="container">
        <p class="mb-0"><i class="bi bi-megaphone-fill"></i> Plateforme Annonces &copy; {{ date('Y') }}</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>

<!-- Chatbot -->
<div id="chatbot-btn" onclick="toggleChat()"
    style="position:fixed; bottom:30px; right:30px; width:55px; height:55px;
    background:linear-gradient(135deg,#e94560,#c73652); border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; box-shadow:0 5px 20px rgba(233,69,96,0.5); z-index:9999;">
    <i class="bi bi-chat-dots-fill text-white fs-4"></i>
</div>

<div id="chatbot-window"
    style="position:fixed; bottom:100px; right:30px; width:320px;
    background:white; border-radius:15px; box-shadow:0 10px 40px rgba(0,0,0,0.2);
    display:none; flex-direction:column; z-index:9999; overflow:hidden;">
    <div style="background:linear-gradient(135deg,#1a1a2e,#0f3460); padding:15px; color:white;">
        <h6 class="mb-0"><i class="bi bi-robot"></i> Assistant IA</h6>
        <small style="opacity:0.7;">Comment puis-je vous aider ?</small>
    </div>
    <div id="chat-messages"
        style="height:300px; overflow-y:auto; padding:15px; display:flex; flex-direction:column; gap:10px;">
        <div style="background:#f0f0f0; border-radius:10px 10px 10px 0; padding:10px; max-width:85%; font-size:13px;">
            Bonjour ! Je suis votre assistant. Comment puis-je vous aider ?
        </div>
    </div>
    <div style="padding:10px; border-top:1px solid #eee; display:flex; gap:8px;">
        <input type="text" id="chat-input" placeholder="Votre message..."
            style="flex:1; border:1px solid #ddd; border-radius:10px; padding:8px 12px; font-size:13px; outline:none;"
            onkeypress="if(event.key==='Enter') envoyerMessage()">
        <button onclick="envoyerMessage()"
            style="background:linear-gradient(135deg,#e94560,#c73652); color:white; border:none; border-radius:10px; padding:8px 12px; cursor:pointer;">
            <i class="bi bi-send"></i>
        </button>
    </div>
</div>

<script>
function toggleChat() {
    const win = document.getElementById('chatbot-window');
    win.style.display = win.style.display === 'none' ? 'flex' : 'none';
}

function envoyerMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    if (!message) return;
    const messagesDiv = document.getElementById('chat-messages');
    messagesDiv.innerHTML += `
        <div style="background:linear-gradient(135deg,#1a1a2e,#0f3460); color:white;
            border-radius:10px 10px 0 10px; padding:10px; max-width:85%;
            align-self:flex-end; font-size:13px;">
            ${message}
        </div>`;
    input.value = '';
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
    messagesDiv.innerHTML += `
        <div id="typing" style="background:#f0f0f0; border-radius:10px;
            padding:10px; max-width:85%; font-size:13px;">
            <i class="bi bi-three-dots"></i> En train d'écrire...
        </div>`;
    fetch('{{ route("ai.chatbot") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: message })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('typing').remove();
        messagesDiv.innerHTML += `
            <div style="background:#f0f0f0; border-radius:10px 10px 10px 0;
                padding:10px; max-width:85%; font-size:13px;">
                ${data.reponse}
            </div>`;
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    })
    .catch(() => {
        document.getElementById('typing').remove();
        messagesDiv.innerHTML += `
            <div style="background:#f0f0f0; border-radius:10px; padding:10px; font-size:13px;">
                Désolé, une erreur s'est produite.
            </div>`;
    });
}
</script>

</body>
</html>