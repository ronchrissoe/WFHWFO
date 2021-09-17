<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role =  DB::table('m_role')->where('nik', $request->session()->get('Nik'))->first();
        if ( !$role )
        {
            abort(403);
        }
        else{
            return $next($request);
        }
    }
}
