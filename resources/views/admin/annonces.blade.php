@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="page-title"><i class="bi bi-list-ul"></i> Gestion des annonces</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="border-radius:10px;">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover shadow-sm" style="border-radius:15px; overflow:hidden;">
        <thead style="background:linear-gradient(135deg,#1a1a2e,#0f3460); color:white;">
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Utilisateur</th>
                <th>Catégorie</th>
                <th>Ville</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($annonces as $annonce)
            <tr>
                <td>{{ $annonce->id }}</td>
                <td class="fw-bold">{{ $annonce->titre }}</td>
                <td>{{ $annonce->user->name }}</td>
                <td><span class="badge bg-primary">{{ $annonce->categorie->nom }}</span></td>
                <td>{{ $annonce->ville }}</td>
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
                    <div class="d-flex gap-1 flex-wrap">
                        <a href="{{ route('annonces.show', $annonce) }}"
                            class="btn btn-sm text-white" style="background:#1a1a2e;border-radius:8px;">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.annonces.edit', $annonce) }}"
                            class="btn btn-sm btn-primary" style="border-radius:8px;">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($annonce->statut === 'en_attente')
                        <form method="POST" action="{{ route('admin.approuver', $annonce) }}">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-success btn-sm" style="border-radius:8px;">
                                <i class="bi bi-check"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.rejeter', $annonce) }}">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-warning btn-sm" style="border-radius:8px;">
                                <i class="bi bi-x"></i>
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.annonces.delete', $annonce) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" style="border-radius:8px;"
                                onclick="return confirm('Supprimer ?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Aucune annonce</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $annonces->links() }}
@endsection