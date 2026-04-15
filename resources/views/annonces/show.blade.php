@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm" style="border-radius:15px;">
            @if($annonce->photo_url)
                <img src="{{ $annonce->photo_url }}" class="card-img-top" style="height:350px;object-fit:cover">
            @elseif($annonce->photo)
                <img src="{{ Storage::url($annonce->photo) }}" class="card-img-top" style="height:350px;object-fit:cover">
            @endif
            <div class="card-body p-4">
                <span class="badge bg-primary mb-2">{{ $annonce->categorie->nom }}</span>
                <h2 class="fw-bold">{{ $annonce->titre }}</h2>
                <p class="text-muted">
                    <i class="bi bi-geo-alt-fill text-danger"></i> {{ $annonce->ville }} &nbsp;|&nbsp;
                    <i class="bi bi-person-fill"></i> {{ $annonce->user->name }} &nbsp;|&nbsp;
                    <i class="bi bi-calendar"></i> {{ $annonce->created_at->format('d/m/Y') }}
                </p>
                @if($annonce->prix)
                    <h4 class="fw-bold" style="color:#e94560;">
                        {{ number_format($annonce->prix, 2) }} DT
                    </h4>
                @endif
                <hr>
<div class="d-flex gap-2 mb-3">
    <button onclick="traduire('arabe')" class="btn btn-sm text-white"
        style="background:#1a1a2e; border-radius:10px;">
        عربي
    </button>
    <button onclick="traduire('anglais')" class="btn btn-sm text-white"
        style="background:#0f3460; border-radius:10px;">
        English
    </button>
    <button onclick="resetTexte()" class="btn btn-sm btn-secondary"
        style="border-radius:10px;">
        <i class="bi bi-arrow-counterclockwise"></i> Original
    </button>
</div>
<div id="loading-traduction" class="d-none">
    <div class="spinner-border spinner-border-sm text-primary"></div>
    Traduction en cours...
</div>
<p class="lead" id="description-texte">{{ $annonce->description }}</p>

<script>
const texteOriginal = @json($annonce->description);

function traduire(langue) {
    document.getElementById('loading-traduction').classList.remove('d-none');
    document.getElementById('description-texte').style.opacity = '0.5';

    fetch('{{ route("ai.traduire") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            texte: texteOriginal,
            langue: langue
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('description-texte').textContent = data.traduction;
        document.getElementById('description-texte').style.opacity = '1';
        document.getElementById('loading-traduction').classList.add('d-none');
    })
    .catch(() => {
        document.getElementById('loading-traduction').classList.add('d-none');
        document.getElementById('description-texte').style.opacity = '1';
    });
}

function resetTexte() {
    document.getElementById('description-texte').textContent = texteOriginal;
}
</script>

            </div>
        </div>

        @auth
            @if(auth()->id() === $annonce->user_id)
            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('annonces.edit', $annonce) }}" class="btn btn-warning" style="border-radius:10px;">
                    <i class="bi bi-pencil"></i> Modifier
                </a>
                <form method="POST" action="{{ route('annonces.destroy', $annonce) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="border-radius:10px;"
                        onclick="return confirm('Supprimer cette annonce ?')">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
            </div>
            @endif
        @endauth
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm" style="border-radius:15px;">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold">
                    <i class="bi bi-person-circle"></i> Annonceur
                </h5>
                <p class="text-muted mb-1">{{ $annonce->user->name }}</p>
                <p class="text-muted">{{ $annonce->user->email }}</p>

                @auth
                    @if(auth()->id() !== $annonce->user_id)
                        <a href="{{ route('messages.conversation', $annonce) }}"
                            class="btn w-100 text-white mb-2"
                            style="background:linear-gradient(135deg,#1a1a2e,#0f3460); border-radius:10px;">
                            <i class="bi bi-chat-dots"></i> Envoyer un message
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="btn w-100 text-white"
                        style="background:linear-gradient(135deg,#e94560,#c73652); border-radius:10px;">
                        <i class="bi bi-box-arrow-in-right"></i> Connectez-vous pour contacter
                    </a>
                @endauth
            </div>
        </div>

        <!-- Statut annonce -->
        <div class="card shadow-sm mt-3" style="border-radius:15px;">
            <div class="card-body p-4">
                <h5 class="fw-bold">Statut</h5>
                @if($annonce->statut === 'active')
                    <span class="badge bg-success">Active</span>
                @elseif($annonce->statut === 'en_attente')
                    <span class="badge bg-warning text-dark">En attente de validation</span>
                @else
                    <span class="badge bg-danger">Rejetée</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection