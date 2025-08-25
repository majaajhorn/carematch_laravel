<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserByUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$allowedUserTypes): Response
    {
        // dd($allowedUserTypes);
        if ($allowedUserTypes === []) {
            abort(403, 'Error');
        }

        $user = $request->user();

        if (!in_array(get_class($user?->user), $allowedUserTypes)) {
           
                abort(403, 'Access denied. You are not authorized to view this page.');
            }
       
        return $next($request);
    }
}
