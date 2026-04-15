<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function index()
    {
        $annonces = Annonce::where('statut', 'active')
                    ->with('categorie', 'user')
                    ->latest()
                    ->paginate(12);
        $categories = Categorie::all();
        return view('annonces.index', compact('annonces', 'categories'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('annonces.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|max:255',
            'description' => 'required',
            'ville' => 'required',
            'categorie_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|max:2048',
            'photo_url' => 'nullable|url',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Annonce::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'ville' => $request->ville,
            'categorie_id' => $request->categorie_id,
            'photo' => $photoPath,
            'photo_url' => $request->photo_url,
            'user_id' => auth()->id(),
            'statut' => auth()->user()->role === 'admin' ? 'active' : 'en_attente',
        ]);

        return redirect()->route('annonces.index')
                ->with('success', 'Annonce soumise avec succès !');
    }

    public function show(Annonce $annonce)
    {
        return view('annonces.show', compact('annonce'));
    }

    public function edit(Annonce $annonce)
    {
        $categories = Categorie::all();
        return view('annonces.edit', compact('annonce', 'categories'));
    }

    public function update(Request $request, Annonce $annonce)
    {
        $request->validate([
            'titre' => 'required|max:255',
            'description' => 'required',
            'ville' => 'required',
            'categorie_id' => 'required|exists:categories,id',
            'photo_url' => 'nullable|url',
        ]);

        $photoPath = $annonce->photo;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $annonce->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'ville' => $request->ville,
            'categorie_id' => $request->categorie_id,
            'photo' => $photoPath,
            'photo_url' => $request->photo_url,
        ]);

        return redirect()->route('annonces.show', $annonce)
                ->with('success', 'Annonce modifiée avec succès !');
    }

    public function destroy(Annonce $annonce)
    {
        $annonce->delete();
        return redirect()->route('annonces.index')
                ->with('success', 'Annonce supprimée !');
    }

    public function search(Request $request)
    {
        $query = Annonce::where('statut', 'active')->with('categorie', 'user');

        if ($request->categorie_id) {
            $query->where('categorie_id', $request->categorie_id);
        }
        if ($request->ville) {
            $query->where('ville', 'like', '%'.$request->ville.'%');
        }
        if ($request->prix_max) {
            $query->where('prix', '<=', $request->prix_max);
        }

        $annonces = $query->latest()->paginate(12);
        $categories = Categorie::all();

        return view('annonces.index', compact('annonces', 'categories'));
    }

    public function mesAnnonces()
    {
        $annonces = Annonce::where('user_id', auth()->id())
                    ->with('categorie')
                    ->latest()
                    ->paginate(10);
        return view('annonces.mes-annonces', compact('annonces'));
    }
}