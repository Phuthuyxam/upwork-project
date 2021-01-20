<?php

namespace App\Modules\User\Middleware;
use App\Core\Glosary\RoleConfigs;
use Auth;
use Closure;

class FirstLoginMiddle
{
    public function handle($request, Closure $next) {
        if ( Auth::check() ) {
            $firstLoginFlag = Auth::user()->first_login;
            if(!$firstLoginFlag || Auth::user()->role == RoleConfigs::SUPPERADMIN['VALUE']) return  $next($request);
            return redirect()->route('user.verify.index');

        }

        return $next($request);
    }
}
