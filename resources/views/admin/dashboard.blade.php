@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="page-title"><i class="bi bi-speedometer2"></i> Dashboard Admin</h2>
    </div>
</div>

<!-- Statistiques -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white shadow-sm" style="background:linear-gradient(135deg,#1a1a2e,#0f3460); border-radius:15px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-megaphone fs-1"></i>
                <h3 class="mt-2 fw-bold">{{ $totalAnnonces }}</h3>
                <p class="mb-0">Total annonces</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm" style="background:#f59e0b; border-radius:15px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-clock fs-1"></i>
                <h3 class="mt-2 fw-bold">{{ $annoncesEnAttente }}</h3>
                <p class="mb-0">En attente</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white shadow-sm" style="background:#10b981; border-radius:15px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-check-circle fs-1"></i>
                <h3 class="mt-2 fw-bold">{{ $annoncesActives }}</h3>
                <p class="mb-0">Actives</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white shadow-sm" style="background:#06b6d4; border-radius:15px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-people fs-1"></i>
                <h3 class="mt-2 fw-bold">{{ $totalUsers }}</h3>
                <p class="mb-0">Utilisateurs</p>
            </div>
        </div>
    </div>
</div>

<!-- Graphiques -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm" style="border-radius:15px;">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Annonces par catégorie</h5>
                <canvas id="chartCategories" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm" style="border-radius:15px;">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Annonces par statut</h5>
                <canvas id="chartStatuts" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm" style="border-radius:15px;">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Annonces par mois ({{ date('Y') }})</h5>
                <canvas id="chartMois" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Menu Admin -->
<div class="row g-3">
    <div class="col-md-4">
        <a href="{{ route('admin.annonces') }}" class="card text-decoration-none shadow-sm" style="border-radius:15px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-list-ul fs-1 text-dark"></i>
                <h5 class="mt-2">Gérer les annonces</h5>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.categories.index') }}" class="card text-decoration-none shadow-sm" style="border-radius:15px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-tags fs-1 text-dark"></i>
                <h5 class="mt-2">Gérer les catégories</h5>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.users') }}" class="card text-decoration-none shadow-sm" style="border-radius:15px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-people fs-1 text-dark"></i>
                <h5 class="mt-2">Gérer les utilisateurs</h5>
            </div>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const categoriesLabels = @json($annoncesParCategorie->pluck('nom'));
const categoriesData = @json($annoncesParCategorie->pluck('annonces_count'));

new Chart(document.getElementById('chartCategories'), {
    type: 'doughnut',
    data: {
        labels: categoriesLabels,
        datasets: [{
            data: categoriesData,
            backgroundColor: [
                '#1a1a2e', '#e94560', '#0f3460',
                '#10b981', '#f59e0b', '#06b6d4'
            ],
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

new Chart(document.getElementById('chartStatuts'), {
    type: 'bar',
    data: {
        labels: ['Actives', 'En attente', 'Rejetées'],
        datasets: [{
            label: 'Annonces',
            data: [{{ $annoncesActives }}, {{ $annoncesEnAttente }}, {{ $annoncesRejetees }}],
            backgroundColor: ['#10b981', '#f59e0b', '#e94560'],
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

const moisLabels = ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Déc'];
const moisData = Array(12).fill(0);
@foreach($annoncesParMois as $item)
    moisData[{{ $item->mois - 1 }}] = {{ $item->total }};
@endforeach

new Chart(document.getElementById('chartMois'), {
    type: 'line',
    data: {
        labels: moisLabels,
        datasets: [{
            label: 'Annonces publiées',
            data: moisData,
            borderColor: '#e94560',
            backgroundColor: 'rgba(233,69,96,0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#e94560',
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endsection