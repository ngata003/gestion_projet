<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Auth;
use Illuminate\Http\Request;
use Session;

class ProjetController extends Controller
{
    //

    public function add_projet(Request $request)
    {
        $user = Auth::user();

        $messages = [
            'nom_projet.regex' => 'Le nom doit contenir uniquement des lettres et des espaces.',
            'nbre_jours.required' => 'Le nombre de jours est obligatoire.',
            'nom_projet.required' => 'Le nom est requis.',
        ];
        $request->validate([
            'nom_projet' => 'required|string|max:255|unique:projets,nom_projet|regex:/^[a-zA-ZÀ-ÿ\s-]+$/',
            'nbre_jours' => 'required',
        ], $messages);

        $projet = new Projet();

        $projet->nom_projet = $request->input('nom_projet');
        $projet->nbre_jours = $request->input('nbre_jours');
        $projet->nom_gestionnaire  = $user->name;

        $projet->save();
        $user->projet_created = true;
        $user->save();

        Session::put('project_active', $projet);
        return redirect('/taches')->with('ajout_projet', 'Projet ajouté avec succès');
    }
}
