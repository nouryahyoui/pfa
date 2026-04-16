@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm" style="border-radius:15px;">
            <div class="card-header bg-warning" style="border-radius:15px 15px 0 0;">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Modifier l'annonce</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('annonces.update', $annonce) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Titre</label>
                        <input type="text" name="titre"
                            class="form-control @error('titre') is-invalid @enderror"
                            value="{{ old('titre', $annonce->titre) }}"
                            maxlength="255"
                            style="border-radius:10px;">
                        @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                        <input type="text" name="ville"
                            class="form-control"
                            value="{{ old('ville', $annonce->ville) }}"
                            maxlength="100"
                            style="border-radius:10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prix (optionnel)</label>
                        <input type="number" name="prix"
                            class="form-control"
                            value="{{ old('prix', $annonce->prix) }}"
                            min="0"
                            step="0.01"
                            oninput="if(this.value < 0) this.value = 0;"
                            style="border-radius:10px;">
                        <small class="text-muted">Entrez un prix positif en DT</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="5"
                            class="form-control"
                            maxlength="2000"
                            style="border-radius:10px;">{{ old('description', $annonce->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Photo URL</label>
                        <input type="url" name="photo_url"
                            class="form-control"
                            value="{{ old('photo_url', $annonce->photo_url) }}"
                            placeholder="https://exemple.com/image.jpg"
                            style="border-radius:10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ou uploader une photo</label>
                        <input type="file" name="photo"
                            class="form-control"
                            accept="image/jpeg,image/png,image/jpg"
                            style="border-radius:10px;">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning btn-lg" style="border-radius:10px;">
                            <i class="bi bi-save"></i> Sauvegarder
                        </button>
                        <a href="{{ route('annonces.show', $annonce) }}"
                            class="btn btn-secondary btn-lg" style="border-radius:10px;">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection