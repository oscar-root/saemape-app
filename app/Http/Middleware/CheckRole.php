<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    // 1. Vérifier si l'utilisateur est connecté
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    // 2. Vérifier si son rôle est dans la liste autorisée
    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, "Accès refusé : Votre rôle (" . auth()->user()->role . ") ne vous permet pas d'accéder à cette ressource SAEMAPE.");
    }

    return $next($request);
}
}
