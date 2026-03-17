<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;

class BookingController extends Controller
{

public function store(Request $request,$ticket_id)
{
    $ticket = Ticket::findOrFail($ticket_id);

    $validated = $request->validate([
        'quantity'=>'required|integer|min:1'
    ]);

    if($validated['quantity'] > $ticket->quantity){
        return response()->json([
            'message'=>'Not enough tickets available'
        ],400);
    }

    $booking = Booking::create([
        'user_id'=>auth()->id(),
        'ticket_id'=>$ticket_id,
        'quantity'=>$validated['quantity'],
        'status'=>'pending'
    ]);

    return response()->json($booking,201);
}

public function index()
{
    $bookings = Booking::with('ticket.event')
        ->where('user_id',auth()->id())
        ->get();

    return response()->json($bookings);
}

public function cancel($id)
{
    $booking = Booking::where('user_id',auth()->id())
        ->findOrFail($id);

    $booking->update([
        'status'=>'cancelled'
    ]);

    return response()->json([
        'message'=>'Booking cancelled'
    ]);
}

}