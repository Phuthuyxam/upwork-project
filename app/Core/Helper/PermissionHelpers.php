<?php


namespace App\Core\Helper;


use App\Core\Glosary\RoleConfigs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PermissionHelpers
{
    public static function canAccess($url)
    {

        $route = collect(Route::getRoutes())->first(function ($route) use ($url) {
            return $route->matches(request()->create($url));
        });
        if (is_null($route)) return false;
        $currentAction = $route->action;
        if (!isset($currentAction['controller']) || empty($currentAction['controller'])) return false;
        $currentAction = $currentAction['controller'];
        list($controller, $method) = explode('@', $currentAction);
        // $controller now is "App\Http\Controllers\FooBarController"
        $controller = preg_replace('/.*\\\/', '', $controller);
        $alias = $controller . "@" . $method;
        if (Auth::check()) {
            $role = Auth::user()->role;
            // check supperadmin
            if ($role == RoleConfigs::SUPPERADMIN['VALUE']) return true;

            $permissions = Auth::user()->getPermission($role);

            // role not register permission
            if (empty($permissions)) return false;

            $checkExitAlias = false;

            foreach ($permissions as $per) {
                $aliasArray = explode('|', $per['alias']);
                if (in_array($alias, $aliasArray)) {
                    $checkExitAlias = true;
                    break;
                }
            }
            if (!$checkExitAlias) return false;
            return true;
        }
        return false;
    }
}
