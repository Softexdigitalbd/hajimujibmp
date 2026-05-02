<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthenticated.');
        }

        if (! $user->hasPermission($permission)) {
            abort(Response::HTTP_FORBIDDEN, __('You do not have permission to perform this action.'));
        }

        return $next($request);
    }
}
