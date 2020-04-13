<?php

namespace App\Http\Middleware;

use Closure;
use Silber\Bouncer\BouncerFacade as Bouncer;

class Admin
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Bouncer::is($request->user())->notAn('admin')) {
            return response()->json(['msg' => 'No se de que me hablas'],403);
        }
        return $next($request);


    }
}
