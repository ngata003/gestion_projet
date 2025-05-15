<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Realisation extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_tache',
        'nom_gestionnaire',
        'nom_projet',
    ];

}
