@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Modifier l'annonce</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('annonces.update', $annonce) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Titre</label>
                        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
                            value="{{ old('titre', $annonce->titre) }}">
                        @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catégorie</label>
                        <select name="categorie_id" class="form-select">
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
                            value="{{ old('ville', $annonce->ville) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prix (optionnel)</label>
                        <input type="number" name="prix" class="form-control"
                            value="{{ old('prix', $annonce->prix) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="5" class="form-control">{{ old('description', $annonce->description) }}</textarea>
                    </div>

                   <div class="mb-3">
    <label class="form-label fw-bold">Photo URL</label>
    <input type="text" name="photo_url" class="form-control"
        placeholder="https://exemple.com/image.jpg"
        value="{{ old('photo_url', $annonce->photo_url) }}"
        style="border-radius:10px;">
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Ou uploader une photo</label>
    <input type="file" name="photo" class="form-control" accept="image/*"
        style="border-radius:10px;">
</div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="bi bi-save"></i> Sauvegarder
                        </button>
                        <a href="{{ route('annonces.show', $annonce) }}" class="btn btn-secondary btn-lg">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
