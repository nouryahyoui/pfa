@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="fw-bold"><i class="bi bi-people"></i> Gestion des utilisateurs</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Inscrit le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role === 'admin')
                        <span class="badge bg-danger">Admin</span>
                    @else
                        <span class="badge bg-secondary">Utilisateur</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.delete', $user) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Supprimer cet utilisateur ?')">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Aucun utilisateur</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $users->links() }}
@endsection