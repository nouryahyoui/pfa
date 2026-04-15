@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<div class="hero-section text-white text-center py-5 mb-4 rounded-4"
    style="background: linear-gradient(135deg, #1a1a2e, #0f3460);">
    <div data-aos="fade-down">
        <h1 class="display-4 fw-bold mb-3">
            <i class="bi bi-megaphone-fill"></i> Trouvez ce que vous cherchez
        </h1>
        <p class="lead mb-0">Des milliers d'annonces à portée de main</p>
    </div>
</div>

<!-- Recherche -->
<div class="search-section mb-4" data-aos="fade-up">
    <form action="{{ route('annonces.search') }}" method="GET">
        <div class="row g-3">
            <div class="col-md-4">
                <select name="categorie_id" class="form-select">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="ville" class="form-control" placeholder="Ville">
            </div>
            <div class="col-md-3">
                <input type="number" name="prix_max" class="form-control" placeholder="Prix max (DT)">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-search">
                    <i class="bi bi-search"></i> Chercher
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Titre -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Toutes les annonces</h2>
    <span class="badge bg-dark rounded-pill fs-6">{{ $annonces->total() }} annonces</span>
</div>

<!-- Liste annonces -->
<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse($annonces as $annonce)
    <div class="col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
        <div class="card h-100 shadow-sm">
        @if($annonce->photo_url)
    <div style="overflow:hidden; height:200px;">
        <img src="{{ $annonce->photo_url }}"
            class="card-img-top w-100 h-100"
            style="object-fit:cover;{{ $annonces->links() }}
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="d-none align-items-center justify-content-center text-white"
            style="height:200px; background:linear-gradient(135deg,#1a1a2e,#0f3460);">
            <i class="bi bi-image fs-1"></i>
        </div>
    </div>
@elseif($annonce->photo)
    <div style="overflow:hidden; height:200px;">
        <img src="{{ Storage::url($annonce->photo) }}"
            class="card-img-top w-100 h-100"
            style="object-fit:cover;">
    </div>
@else
    <div class="d-flex align-items-center justify-content-center text-white"
        style="height:200px; background:linear-gradient(135deg,#1a1a2e,#0f3460);">
        <i class="bi bi-image fs-1"></i>
    </div>
@endif
            <div class="card-body">
                <span class="badge bg-primary mb-2">{{ $annonce->categorie->nom }}</span>
                <h5 class="card-title fw-bold">{{ $annonce->titre }}</h5>
                <p class="text-muted small mb-1">
                    <i class="bi bi-geo-alt-fill text-danger"></i> {{ $annonce->ville }}
                </p>
                <p class="text-muted small">
                    <i class="bi bi-person-fill"></i> {{ $annonce->user->name }}
                </p>
                @if($annonce->prix)
                    <p class="fw-bold fs-5" style="color: #e94560;">
                        {{ number_format($annonce->prix, 2) }} DT
                    </p>
                @endif
            </div>
            <div class="card-footer bg-transparent border-0 pb-3">
                <a href="{{ route('annonces.show', $annonce) }}"
                    class="btn w-100 text-white"
                    style="background: linear-gradient(135deg, #1a1a2e, #0f3460); border-radius:10px;">
                    <i class="bi bi-eye"></i> Voir l'annonce
                </a>
            </div>
        </div>
    </div>
    @empty
        <div class="col-12" data-aos="fade-up">
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="text-muted mt-3">Aucune annonce disponible</h4>
                @auth
                    <a href="{{ route('annonces.create') }}" class="btn btn-publish mt-3">
                        <i class="bi bi-plus-circle"></i> Publier la première annonce
                    </a>
                @endauth
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-4 d-flex justify-content-center">
    {{ $annonces->links('pagination::bootstrap-5') }}
</div>

@endsection