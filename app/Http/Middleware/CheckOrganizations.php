<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrganizations
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is logged in and the organization_id session variable is missing, redirect them to the organizations index.
        if ($request->user() && $request->session()->missing('organization_id')) {
            return redirect()->route('organizations.index');
        }

        // Check if the user is a member of the organization.
        if (!$request->user()->organizations->contains($request->session()->get('organization_id'))) {
            session()->forget('organization_id');
            return redirect()->route('organizations.index');
        }

        setPermissionsTeamId(session('organization_id'));

        return $next($request);
    }
}
