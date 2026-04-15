<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|max:255|unique:categories,nom',
        ]);

        Categorie::create(['nom' => $request->nom]);

        return redirect()->route('admin.categories.index')
                ->with('success', 'Catégorie ajoutée !');
    }

    public function update(Request $request, Categorie $categorie)
    {
        $request->validate([
            'nom' => 'required|max:255',
        ]);

        $categorie->update(['nom' => $request->nom]);

        return redirect()->route('admin.categories.index')
                ->with('success', 'Catégorie modifiée !');
    }

    public function destroy(Categorie $categorie)
    {
        $categorie->delete();
        return redirect()->route('admin.categories.index')
                ->with('success', 'Catégorie supprimée !');
    }
}