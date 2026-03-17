<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Http\Request;

class TicketController extends Controller
{

public function store(Request $request,$event_id)
{
    $event = Event::findOrFail($event_id);

    if($event->created_by != auth()->id()){
        return response()->json(['message'=>'Unauthorized'],403);
    }

    $validated = $request->validate([
        'type'=>'required|string|max:100',
        'price'=>'required|numeric|min:0',
        'quantity'=>'required|integer|min:1'
    ]);

    $ticket = Ticket::create([
        'event_id'=>$event_id,
        'type'=>$validated['type'],
        'price'=>$validated['price'],
        'quantity'=>$validated['quantity']
    ]);

    return response()->json($ticket,201);
}

public function update(Request $request,$id)
{
    $ticket = Ticket::findOrFail($id);

    $validated = $request->validate([
        'type'=>'sometimes|string',
        'price'=>'sometimes|numeric',
        'quantity'=>'sometimes|integer|min:1'
    ]);

    $ticket->update($validated);

    return response()->json($ticket);
}

public function destroy($id)
{
    $ticket = Ticket::findOrFail($id);

    $ticket->delete();

    return response()->json(['message'=>'Ticket deleted']);
}

}