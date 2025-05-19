<?php

namespace App\Http\Controllers;

use App\Mail\passwordGeneratedMail;
use App\Models\Projet;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Session;
use Str;

class UserController extends Controller
{
    //

    public function view_gestionnaires()
    {
        $gestionnaires = User::where('type', 'gestionnaire')->get();
        return view('users.employes',compact('gestionnaires'));
    }

    public function add_inscription(Request $request){
        $messages = [
            'name.regex' => 'Le nom doit contenir uniquement des lettres et des espaces.',
            'email.regex' => 'L\'adresse e-mail doit être au format valide.',
            'contact.regex' => 'Le numéro de contact doit contenir uniquement des chiffres.',
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'contact.required' => 'Le numéro de contact est requis.',
            'password.required' => 'Le mot de passe est requis.',
        ];
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name|regex:/^[a-zA-ZÀ-ÿ\s-]+$/',
            'email' => 'required|string|max:255|unique:users,email|regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
            'contact' => 'required|string|max:255|unique:users,contact|regex:/^\+?[1-9]\d{6,14}$/',
            'password' => 'required|string|max:255',
            'role' => 'required',
            'type'=>'required',
            'image_user' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ], $messages);

        $imageName = null;

        if ($request->hasFile('image_user')) {
            $imageFile = $request->file('image_user');
            $imageName = time().'.'. $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/assets/images'),$imageName);
        }

        $admin = new User();

        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->contact = $request->input('contact');
        $admin->password = bcrypt($request->input('password'));
        $admin->role = $request->input('role');
        $admin->type = $request->input('type');
        $admin->image_user = $imageName;

        $admin->save();

        return redirect('/connexion')->with('inscription','inscription réussie');
    }

    public function add_gestionnaires(Request $request){
        //dd($request->all());
        $user = Auth::user();

        $messages = [
            'name.regex' => 'Le nom doit contenir uniquement des lettres et des espaces.',
            'email.regex' => 'L\'adresse e-mail doit être au format valide.',
            'contact.regex' => 'Le numéro de contact doit contenir uniquement des chiffres.',
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'contact.required' => 'Le numéro de contact est requis.',
        ];

        $request->validate([
            'name' => 'required|string|max:255|unique:users,name|regex:/^[a-zA-ZÀ-ÿ\s-]+$/',
            'email' => 'required|string|max:255|unique:users,email|regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
            'contact' => 'required|string|max:255|unique:users,contact|regex:/^\+?[1-9]\d{6,14}$/',
            'role' => 'required',
            'type'=>'required',
            'image_user' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);

        $project = Session::get('project_active');

        $projectName = $project->nom_projet;

        $passwordFirst = Str::random(10);

        $password = bcrypt($passwordFirst);

         $imageName = null;

        if ($request->hasFile('image_user')) {
            $imageFile = $request->file('image_user');
            $imageName = time().'.'. $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path(path: '/assets/images'),$imageName);
        }

        $gestionnaire = new User();

        $gestionnaire->name = $request->input('name');
        $gestionnaire->email = $request->input('email');
        $gestionnaire->contact = $request->input('contact');
        $gestionnaire->password = $password;
        $gestionnaire->role = $request->input('role');
        $gestionnaire->type = $request->input('type');
        $gestionnaire->nom_gestionnaire = $user->name;
        $gestionnaire->nom_projet = $projectName;
        $gestionnaire->image_user = $imageName;

        $gestionnaire->save();

        Mail::to($gestionnaire->email)->send(new passwordGeneratedMail($gestionnaire, $passwordFirst));

        return back()->with('ajout_gestionnaire', 'Gestionnaire ajouté avec succès.' );
    }

    public function add_connexion(Request $request){
        $messages = [
            'email.required'=>'veuillez remplir la case de email',
            'email.regex' => 'veuillez entrer une adresse email valide regis par les règles',
            'password.required' => 'remplissez la case du mot de passe',
            'password.max' => 'votre mot de passe doit etre inferieur à 12 caractères',
        ];

        $request->validate([
            'email' => 'required|string|max:255|regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
            'password'=>'required|max:12',

        ], $messages);

        $utilisateur = User::where('email',$request->email)->first();

        if(!$utilisateur){
            return back()->with('status_error', 'cet adresse email n\'existe pas ');
        }

        if (!Hash::check($request->password, $utilisateur->password)) {
            return back()->with('status_pas_error', 'votre mot de passe ne correspond pas');
        }

        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials, $request->has('remember'))){
            if( $utilisateur->role === 'admin'){
                if ($utilisateur->projet_created) {
                    $projet = Projet::where('nom_gestionnaire', $utilisateur->name)->first();
                    Session::put('project_active',$projet);

                    return redirect('/utilisateurs');
                }

                else{
                    return redirect('/projet')->with('status_connexion', 'connexion effectuée avec succès');
                }
            }

            else if($utilisateur->type === 'gestionnaire') {

                $projet = projet::where('nom_projet', $utilisateur->nom_projet)->first();
                Session::put('projet_active',$projet);

                return redirect('/mesTaches')->with('status_connexion', 'connexion effectuée avec succès');
            }
        }

        else{

            return redirect('/connexion')->with('status_connexion_error', 'veuillez revisiter vos coordonnées de connexion et puis relancez');
        }
    }

    public function delete_gestionnaires($id){
        $gestionnaire = User::find($id);
        $gestionnaire->delete();
        return back()->with('delete_gestionnaire', 'Gestionnaire supprimé avec succès');
    }

    public function edit_gestionnaires(Request $request, $id){

        $gestionnaire = User::find($id);

        $messages = [
            'name.regex' => 'Le nom doit contenir uniquement des lettres et des espaces.',
            'email.regex' => 'L\'adresse e-mail doit être au format valide.',
            'contact.regex' => 'Le numéro de contact doit contenir uniquement des chiffres.',
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'contact.required' => 'Le numéro de contact est requis.',
            'role.required'=>'veuillez choisir un rôle',
        ];

        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s-]+$/',
            'email' => 'required|string|max:255|regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
            'contact' => 'required|string|max:255|regex:/^\+?[1-9]\d{6,14}$/',
            'role' => 'required',
        ], $messages);

        $gestionnaire->name = $request->input('name');
        $gestionnaire->email = $request->input('email');
        $gestionnaire->contact = $request->input('contact');
        $gestionnaire->role = $request->input('role');

        $gestionnaire->save();

        return back()->with('edit_gestionnaire', 'Gestionnaire modifié avec succès');
    }

    public function view_profil(){
        $user = Auth::user();
        return view('users.profil',compact('user'));
    }
 

}
