<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null, $guard = null)
    {
        $authGuard = app('auth')->guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        if (! is_null($permission)) {
            $permissions = is_array($permission)
                ? $permission
                : explode('|', $permission);
        }

        // Use Laravel's built-in method to get the route name
        if (is_null($permission)) {
            $permission = $request->route()->getName(); // Get route name directly

            $permissions = array($permission);
        }
        // foreach ($permissions as $permission) {
        //     if ($authGuard->user()->can($permission)) {
                return $next($request);
        //     }
        // }

        // throw UnauthorizedException::forPermissions($permissions);
    }
}
