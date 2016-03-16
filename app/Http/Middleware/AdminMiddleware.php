<?php

namespace App\Http\Middleware;

use Closure;
use App\User as User;

class AdminMiddleware
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
        $id = $request->input('user_id');

        if ( !User::isAdmin($id) )
            return response()->json([
                'error'   => "401",
                'success' => false,
                'message' => 'Not an admin user'
            ], 401);

        return $next($request);
    }
}
