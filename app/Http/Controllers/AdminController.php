<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function dashboard()
{
    $totalAnnonces = Annonce::count();
    $totalUsers = User::count();
    $annoncesEnAttente = Annonce::where('statut', 'en_attente')->count();
    $annoncesActives = Annonce::where('statut', 'active')->count();
    $annoncesRejetees = Annonce::where('statut', 'rejetee')->count();

    $annoncesParCategorie = \App\Models\Categorie::withCount('annonces')->get();

    $annoncesParMois = Annonce::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
        ->whereYear('created_at', date('Y'))
        ->groupBy('mois')
        ->orderBy('mois')
        ->get();

    return view('admin.dashboard', compact(
        'totalAnnonces',
        'totalUsers',
        'annoncesEnAttente',
        'annoncesActives',
        'annoncesRejetees',
        'annoncesParCategorie',
        'annoncesParMois'
    ));
}

    public function annonces()
    {
        $annonces = Annonce::with('user', 'categorie')->latest()->paginate(15);
        return view('admin.annonces', compact('annonces'));
    }

    public function approuver(Annonce $annonce)
    {
        $annonce->update(['statut' => 'active']);
        Notification::create([
            'user_id' => $annonce->user_id,
            'message' => 'Votre annonce "' . $annonce->titre . '" a été approuvée !',
            'lu' => false,
        ]);
        return redirect()->back()->with('success', 'Annonce approuvée !');
    }

    public function rejeter(Annonce $annonce)
    {
        $annonce->update(['statut' => 'rejetee']);
        Notification::create([
            'user_id' => $annonce->user_id,
            'message' => 'Votre annonce "' . $annonce->titre . '" a été rejetée.',
            'lu' => false,
        ]);
        return redirect()->back()->with('success', 'Annonce rejetée !');
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Utilisateur supprimé !');
    }
    public function editAnnonce(Annonce $annonce)
{
    $categories = \App\Models\Categorie::all();
    return view('admin.edit-annonce', compact('annonce', 'categories'));
}

public function updateAnnonce(Request $request, Annonce $annonce)
{
    $request->validate([
        'titre' => 'required|max:255',
        'description' => 'required',
        'ville' => 'required',
        'categorie_id' => 'required|exists:categories,id',
    ]);

    $annonce->update([
        'titre' => $request->titre,
        'description' => $request->description,
        'prix' => $request->prix,
        'ville' => $request->ville,
        'categorie_id' => $request->categorie_id,
        'photo_url' => $request->photo_url,
        'statut' => $request->statut,
    ]);

    return redirect()->route('admin.annonces')
            ->with('success', 'Annonce modifiée !');
}

public function deleteAnnonce(Annonce $annonce)
{
    $annonce->delete();
    return redirect()->route('admin.annonces')
            ->with('success', 'Annonce supprimée !');
}
}