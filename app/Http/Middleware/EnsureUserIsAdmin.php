<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Allow super-admins AND staff users who have a role assigned
        if (! $user || (! $user->is_admin && ! $user->role_id)) {
            abort(Response::HTTP_FORBIDDEN, __('You do not have access to the admin area.'));
        }

        return $next($request);
    }
}
