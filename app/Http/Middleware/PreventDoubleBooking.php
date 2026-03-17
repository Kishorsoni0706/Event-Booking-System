<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDoubleBooking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle($request, Closure $next)
{
    $exists = Booking::where('user_id',auth()->id())
        ->where('ticket_id',$request->ticket_id)
        ->where('status','confirmed')
        ->exists();

    if($exists)
        return response()->json(['error'=>'Already booked']);

    return $next($request);
}
}
