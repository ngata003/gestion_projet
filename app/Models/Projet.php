<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_projet',
        'nbre_jours',
        'nom_gestionnaire',
    ];

    public function taches()
    {
        return $this->hasMany(Tache::class, 'nom_projet', 'nom_projet');
    }
    public function realisations()
    {
        return $this->hasMany(Realisation::class, 'nom_projet', 'nom_projet');
    }
    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'nom_gestionnaire', 'name');
    }

}
