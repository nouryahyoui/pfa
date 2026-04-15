<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
   protected $fillable = [
    'titre',
    'description',
    'prix',
    'photo',
    'photo_url',
    'ville',
    'statut',
    'user_id',
    'categorie_id'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }
}