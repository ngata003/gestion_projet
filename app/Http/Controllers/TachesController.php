<?php

namespace App\Http\Controllers;

use App\Models\Realisation;
use App\Models\Tache;
use App\Models\Tache_realisation;
use App\Models\TacheRealisees;
use App\Models\Taches_realisation;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Session;

class TachesController extends Controller
{
    //

    public function view_realisations(){
        $projet = Session::get('project_active');
        $user = Auth::user();

        if ($user->type == 'admin') {

            $taches = Tache::where('status',0)->get();
            $employes = User::where('type','gestionnaire')->get();
            $gestionnaires = Realisation::where('nom_projet',$projet->nom_projet)->select('nom_gestionnaire','id')->distinct()->get();

            $statistiques = [];

            foreach ($gestionnaires as $gest) {
                $id_realisation = Realisation::where('nom_projet',$projet->nom_projet)->where('nom_gestionnaire',$gest->nom_gestionnaire)->pluck('id')->first();
                $taches_real = Taches_realisation::where('id_realisation',$id_realisation)->get();

                $total = $taches_real->count();

                $faites = Taches_realisation::where('id_realisation',$id_realisation)->where('status','fait')->count();
                $non_faites = Taches_realisation::where('id_realisation',$id_realisation)->where('status','non_fait')->count();
                $evolution = $total > 0 ? round(($faites / $total) * 100,2) : 0;

                $statistiques [] = [
                    'id' => $gest->id,
                    'nom_gestionnaire' => $gest->nom_gestionnaire,
                    'total' => $total,
                    'faites' => $faites,
                    'non_faites' => $non_faites,
                    'evolution' => $evolution
                ];
            }

            return view('realisations.realisation',compact('employes','taches','statistiques'));
        }

    }

    public function taskAdded(Request $request){

        $user = Auth::user();
        $project = Session::get('project_active');

        $request->validate([
            'nom_tache' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s-]+$/',
        ]);

        $task = new Tache();

        $task->nom_tache = $request->input('nom_tache');
        $task->status = false;
        $task->nom_gestionnaire = $user->name;
        $task->nom_projet = $project->nom_projet;
        $task->save();

        return back()->with('taskAdded', 'Tâche ajoutée avec succès');

    }

    public function AllTaches(){
        $project = Session::get('project_active');
        $taches = Tache::where('nom_projet',$project->nom_projet)->get();

        return view('taches.taches',compact('taches'));
    }

    public function delete_taches($id){
        $taches = Tache::find($id);
        $taches->delete();

        return back()->with('taskDeleted','tache supprimée avec succès');
    }

    public function edit_taches(Request $request, $id){

        $tache = Tache::find($id);

        $messages = [
            'nom_tache.regex' => 'Le nom doit contenir uniquement des lettres et des espaces.',
        ];

        $request->validate([
            'nom_tache' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s-]+$/',
        ], $messages);

        $tache->nom_tache = $request->input('nom_tache');

        $tache->save();

        return back()->with('taskEdited', 'tache modifiée avec succès');
    }

    public function add_realisations(Request $request){

        $user = Auth::user();
        $project = Session::get('project_active');

        $request->validate([
            'nom_gestionnaire' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s-]+$/',
        ]);

        $realisation = new Realisation();
        $realisation->nom_gestionnaire = $request->input('nom_gestionnaire');
        $realisation->nom_projet = $project->nom_projet;
        $realisation->nom_proprietaire = $user->name;
        $realisation->save();

        $id_realisation = $realisation->id;

        $numRows = $request->input('numRows');

        for ($i = 0; $i < $numRows; $i++) {

            $tacheRealisee = new Taches_realisation();

            $tacheRealisee->nom_tache = $request->input('nom_tache' . $i);
            $tacheRealisee->description = $request->input('description' . $i);
            $tacheRealisee->date_debut = $request->input('date_debut' . $i);
            $tacheRealisee->date_fin = $request->input('date_fin' . $i);
            $tacheRealisee->id_realisation = $id_realisation;
            $tacheRealisee->status = "non_fait";

            $tacheRealisee->nom_gestionnaire = $request->input('nom_gestionnaire');
            $tacheRealisee->nom_projet = $project->nom_projet;

            $tacheRealisee->save();


            $taches = Tache::where('nom_tache',$tacheRealisee->nom_tache)->first();
            $taches->status = true;
            $taches->save();
        }

        return back()->with('realisationAdded', 'réalisation ajoutée avec succès');
    }

    public function mesTaches(){
        $user = Auth::user();
        $project = Session::get('projet_active'); // ✅ correspond à la clé définie à la connexion

        if (!$project) {
            return redirect('/')->with('error', 'Aucun projet actif sélectionné.');
        }

        $taches = Taches_realisation::where('nom_gestionnaire', $user->name)
                    ->where('nom_projet', $project->nom_projet)
                    ->get();

        return view('taches.mesTaches', compact('taches'));
    }

    public function afficher_details($id){
        $taches = Taches_realisation::where('id_realisation',$id)->get();
        return response()->json($taches);
    }

    public function delete_realisations($id){

        $realisations = Realisation::find($id);
        $realisations->delete();

        $taches_realisations = Taches_realisation::where('id_realisation',$id)->get();

        foreach ($taches_realisations as $toch) {
            $tache = Tache::where('nom_tache',$toch->nom_tache)->first();
            if($tache) {
             $tache->status = false;
             $tache->save();
            }
        }

        Taches_realisation::where('id_realisation',$id)->delete();

        return back()->with('realisationDeleted','réalisation supprimée avec succès');
    }

    public function valider_taches($id){
        
        $taches = Taches_realisation::find($id);
        $taches->status = 'fait';
        $taches->save();

        return back()->with('taskValidated','tache validée avec succès');
    }


}
