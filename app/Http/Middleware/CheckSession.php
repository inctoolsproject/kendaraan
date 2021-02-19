<?php

namespace App\Http\Middleware;

use Closure;

// library
use Session;

class CheckSession
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_null(Session::get('info_user'))) {
            return redirect('/');
        }

        return $next($request);
    }
}
