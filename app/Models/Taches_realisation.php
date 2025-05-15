<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taches_realisation extends Model
{
    use HasFactory;

     protected $fillable = [
        'nom_tache',
        'description',
        'status',
        'nom_gestionnaire',
        'nom_projet',
        'id_realisation',
        'date_debut',
        'date_fin',
    ];
}
