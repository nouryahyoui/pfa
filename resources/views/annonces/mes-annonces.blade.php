@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="page-title">
            <i class="bi bi-megaphone"></i> Mes annonces
        </h2>
        <a href="{{ route('annonces.create') }}" class="btn btn-publish">
            <i class="bi bi-plus-circle"></i> Nouvelle annonce
        </a>
    </div>
</div>

@if($annonces->count() > 0)
<div class="table-responsive">
    <table class="table table-hover shadow-sm" style="border-radius:15px; overflow:hidden;">
        <thead style="background:linear-gradient(135deg,#1a1a2e,#0f3460); color:white;">
            <tr>
                <th>Photo</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Ville</th>
                <th>Prix</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($annonces as $annonce)
            <tr data-aos="fade-up">
                <td>
                    @if($annonce->photo_url)
                        <img src="{{ $annonce->photo_url }}" style="width:60px;height:45px;object-fit:cover;border-radius:8px;">
                    @elseif($annonce->photo)
                        <img src="{{ Storage::url($annonce->photo) }}" style="width:60px;height:45px;object-fit:cover;border-radius:8px;">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-white"
                            style="width:60px;height:45px;background:linear-gradient(135deg,#1a1a2e,#0f3460);border-radius:8px;">
                            <i class="bi bi-image"></i>
                        </div>
                    @endif
                </td>
                <td class="fw-bold">{{ $annonce->titre }}</td>
                <td><span class="badge bg-primary">{{ $annonce->categorie->nom }}</span></td>
                <td><i class="bi bi-geo-alt-fill text-danger"></i> {{ $annonce->ville }}</td>
                <td>
                    @if($annonce->prix)
                        <span style="color:#e94560;" class="fw-bold">{{ number_format($annonce->prix, 2) }} DT</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>
                    @if($annonce->statut === 'active')
                        <span class="badge bg-success">Active</span>
                    @elseif($annonce->statut === 'en_attente')
                        <span class="badge bg-warning text-dark">En attente</span>
                    @else
                        <span class="badge bg-danger">Rejetée</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('annonces.show', $annonce) }}"
                            class="btn btn-sm text-white"
                            style="background:#1a1a2e;border-radius:8px;">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('annonces.edit', $annonce) }}"
                            class="btn btn-sm btn-warning"
                            style="border-radius:8px;">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('annonces.destroy', $annonce) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" style="border-radius:8px;"
                                onclick="return confirm('Supprimer cette annonce ?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $annonces->links() }}
</div>

@else
<div class="text-center py-5" data-aos="fade-up">
    <i class="bi bi-megaphone display-1 text-muted"></i>
    <h4 class="text-muted mt-3">Vous n'avez pas encore d'annonces</h4>
    <a href="{{ route('annonces.create') }}" class="btn btn-publish mt-3">
        <i class="bi bi-plus-circle"></i> Publier ma première annonce
    </a>
</div>
@endif
@endsection