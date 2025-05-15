<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
                return redirect('/connexion');
        }

        // Redirections personnalisées selon le rôle
        switch ($user->type) {
            case 'admin':
                return redirect('/taches'); // nom de la route ou url
            case 'gestionnaire':
                return redirect('/mesTaches');
            default:
                return redirect('/connexion'); // ou une autre page par défaut
        }
    }
}
