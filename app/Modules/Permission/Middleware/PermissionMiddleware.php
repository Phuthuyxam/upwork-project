<?php


namespace App\Modules\Permission\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next)
    {
//        $currentAction = \Route::currentRouteAction();
//        list($controller, $method) = explode('@', $currentAction);
//        // $controller now is "App\Http\Controllers\FooBarController"
//        $controller = preg_replace('/.*\\\/', '', $controller);
//        $alias = $controller . "@" . $method;
//
//        if ( Auth::check() )
//        {
//            $role = Auth::user()->role;
//
            return $next($request);
//        }
//        return redirect('/');
    }

}
