@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm" style="border-radius:15px;">
            <div class="card-header text-white" style="background:linear-gradient(135deg,#1a1a2e,#0f3460); border-radius:15px 15px 0 0;">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Modifier l'annonce — Admin</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.annonces.update', $annonce) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Titre</label>
                        <input type="text" name="titre" class="form-control"
                            value="{{ old('titre', $annonce->titre) }}"
                            style="border-radius:10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catégorie</label>
                        <select name="categorie_id" class="form-select" style="border-radius:10px;">
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}"
                                    {{ $annonce->categorie_id == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ville</label>
                        <input type="text" name="ville" class="form-control"
                            value="{{ old('ville', $annonce->ville) }}"
                            style="border-radius:10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prix (optionnel)</label>
                        <input type="number" name="prix" class="form-control"
                            value="{{ old('prix', $annonce->prix) }}"
                            style="border-radius:10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="5" class="form-control"
                            style="border-radius:10px;">{{ old('description', $annonce->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Photo URL</label>
                        <input type="text" name="photo_url" class="form-control"
                            value="{{ old('photo_url', $annonce->photo_url) }}"
                            placeholder="https://exemple.com/image.jpg"
                            style="border-radius:10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Statut</label>
                        <select name="statut" class="form-select" style="border-radius:10px;">
                            <option value="en_attente" {{ $annonce->statut == 'en_attente' ? 'selected' : '' }}>
                                En attente
                            </option>
                            <option value="active" {{ $annonce->statut == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="rejetee" {{ $annonce->statut == 'rejetee' ? 'selected' : '' }}>
                                Rejetée
                            </option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn text-white px-4"
                            style="background:linear-gradient(135deg,#1a1a2e,#0f3460); border-radius:10px;">
                            <i class="bi bi-save"></i> Sauvegarder
                        </button>
                        <a href="{{ route('admin.annonces') }}" class="btn btn-secondary"
                            style="border-radius:10px;">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection