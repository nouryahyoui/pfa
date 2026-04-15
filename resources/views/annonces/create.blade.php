@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Publier une annonce</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('annonces.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Titre</label>
                        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
                            value="{{ old('titre') }}" placeholder="Titre de l'annonce">
                        @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catégorie</label>
                        <select name="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror">
                            <option value="">Choisir une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                        @error('categorie_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ville</label>
                        <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror"
                            value="{{ old('ville') }}" placeholder="Ville">
                        @error('ville')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prix (optionnel)</label>
                        <input type="number" name="prix" class="form-control"
                            value="{{ old('prix') }}" placeholder="Prix en DT">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="5"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Description de l'annonce">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

             <div class="mb-3">
    <label class="form-label fw-bold">Photo URL</label>
    <input type="text" name="photo_url" class="form-control"
        placeholder="https://exemple.com/image.jpg"
        style="border-radius:10px;">
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Ou uploader une photo</label>
    <input type="file" name="photo" class="form-control" accept="image/*"
        style="border-radius:10px;">
</div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark btn-lg">
                            <i class="bi bi-send"></i> Soumettre l'annonce
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
