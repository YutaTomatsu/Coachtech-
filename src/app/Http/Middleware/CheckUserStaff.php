<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\UserStaff;

class CheckUserStaff
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
        $user = Auth::user();

        if($user === null){
            return $next($request);
        }

        if (UserStaff::where('staff_id', $user->id)->exists()) {
            return redirect()->route('staff-redirect');
        }

        // If user is not a staff, redirect to home or any other page you want
        return $next($request);
    }
}
