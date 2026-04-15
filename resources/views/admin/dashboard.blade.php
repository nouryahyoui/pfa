@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold"><i class="bi bi-speedometer2"></i> Dashboard Admin</h2>
    </div>
</div>

<!-- Statistiques -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-dark text-white shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-megaphone fs-1"></i>
                <h3 class="mt-2">{{ $totalAnnonces }}</h3>
                <p class="mb-0">Total annonces</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-clock fs-1"></i>
                <h3 class="mt-2">{{ $annoncesEnAttente }}</h3>
                <p class="mb-0">En attente</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-check-circle fs-1"></i>
                <h3 class="mt-2">{{ $annoncesActives }}</h3>
                <p class="mb-0">Actives</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-people fs-1"></i>
                <h3 class="mt-2">{{ $totalUsers }}</h3>
                <p class="mb-0">Utilisateurs</p>
            </div>
        </div>
    </div>
</div>

<!-- Menu Admin -->
<div class="row g-3">
    <div class="col-md-4">
        <a href="{{ route('admin.annonces') }}" class="card text-decoration-none shadow-sm">
            <div class="card-body text-center py-4">
                <i class="bi bi-list-ul fs-1 text-dark"></i>
                <h5 class="mt-2">Gérer les annonces</h5>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.categories.index') }}" class="card text-decoration-none shadow-sm">
            <div class="card-body text-center py-4">
                <i class="bi bi-tags fs-1 text-dark"></i>
                <h5 class="mt-2">Gérer les catégories</h5>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.users') }}" class="card text-decoration-none shadow-sm">
            <div class="card-body text-center py-4">
                <i class="bi bi-people fs-1 text-dark"></i>
                <h5 class="mt-2">Gérer les utilisateurs</h5>
            </div>
        </a>
    </div>
</div>
@endsection