<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * The roles that are allowed to access the route.
     *
     * @var array
     */
    protected $roles;

    /**
     * Create a new middleware instance.
     *
     * @param  array|string  $roles
     * @return void
     */
    public function __construct($roles = null)
    {
        $this->roles = $roles ?? [];
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$role)
    {
      // si el user auth tiene el rol 'Administrador' puede acceder
        if (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Rector') || Auth::user()->hasRole('SecretarioAcademico')) {
            return $next($request);
        } else if (!Auth::user()->hasRole($role)) {
            return redirect()->back();
        } else if (Auth::user()->hasRole($role)) {
            return $next($request);
        }

    }
}
