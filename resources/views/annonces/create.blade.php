@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm" style="border-radius:15px;">
            <div class="card-header text-white" style="background:linear-gradient(135deg,#1a1a2e,#0f3460); border-radius:15px 15px 0 0;">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Publier une annonce</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('annonces.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Titre</label>
                        <input type="text" name="titre"
                            class="form-control @error('titre') is-invalid @enderror"
                            value="{{ old('titre') }}"
                            placeholder="Titre de l'annonce"
                            maxlength="255"
                            style="border-radius:10px;">
                        @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catégorie</label>
                        <select name="categorie_id"
                            class="form-select @error('categorie_id') is-invalid @enderror"
                            style="border-radius:10px;">
                            <option value="">Choisir une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                        @error('categorie_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ville</label>
                        <input type="text" name="ville"
                            class="form-control @error('ville') is-invalid @enderror"
                            value="{{ old('ville') }}"
                            placeholder="Ville"
                            maxlength="100"
                            style="border-radius:10px;">
                        @error('ville')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prix (optionnel)</label>
                        <input type="number" name="prix"
                            class="form-control"
                            value="{{ old('prix') }}"
                            placeholder="Prix en DT"
                            min="0"
                            step="0.01"
                            oninput="if(this.value < 0) this.value = 0;"
                            style="border-radius:10px;">
                        <small class="text-muted">Entrez un prix positif en DT</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="5"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Description de l'annonce"
                            maxlength="2000"
                            style="border-radius:10px;">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Photo URL</label>
                        <input type="url" name="photo_url"
                            class="form-control"
                            placeholder="https://exemple.com/image.jpg"
                            style="border-radius:10px;">
                        <small class="text-muted">Copiez l'adresse d'une image depuis internet</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ou uploader une photo</label>
                        <input type="file" name="photo"
                            class="form-control"
                            accept="image/jpeg,image/png,image/jpg"
                            style="border-radius:10px;">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-lg text-white"
                            style="background:linear-gradient(135deg,#1a1a2e,#0f3460); border-radius:10px;">
                            <i class="bi bi-send"></i> Soumettre l'annonce
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection