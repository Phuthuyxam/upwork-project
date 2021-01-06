<?php


namespace App\Modules\Permission\Middleware;

use App\Core\Glosary\RoleConfigs;
use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next)
    {
        $currentAction = \Route::currentRouteAction();
        list($controller, $method) = explode('@', $currentAction);
        // $controller now is "App\Http\Controllers\FooBarController"
        $controller = preg_replace('/.*\\\/', '', $controller);
        $alias = $controller . "@" . $method;

        if ( Auth::check() )
        {
            $role = Auth::user()->role;
            // check supperadmin
            if($role == RoleConfigs::SUPPERADMIN['VALUE']) return $next($request);

            $permissions = Auth::user()->getPermission($role);

            // role not register permission
            if( empty($permissions) ) return redirect('/');

            $checkExitAlias = false;

            foreach ($permissions as $per) {
                $aliasArray = explode('|', $per['alias']);
                if(in_array($alias, $aliasArray)) {
                    $checkExitAlias = true;
                    break;
                }
            }
            if(!$checkExitAlias) return redirect('/');
            return $next($request);
        }
        return redirect('/');
    }

}
