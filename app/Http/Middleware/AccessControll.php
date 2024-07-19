<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccessControll
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
  
{
    $User = auth()->user();

    $User_Role = Role::find($User->role_id);
    $PermissionName = $request->route()->getName();

     $hasPermission = $User_Role->check($PermissionName);
    if (!$hasPermission) {
        return response()->json(['error' => 'Unauthorized action.  '],403);
      }
        return $next($request);
    }
}
