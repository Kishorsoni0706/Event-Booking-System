<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{

public function index(Request $request)
{
    $query = Event::with('tickets');

    if($request->search){
        $query->where('title','like','%'.$request->search.'%');
    }

    if($request->date){
        $query->whereDate('date',$request->date);
    }

    if($request->location){
        $query->where('location',$request->location);
    }

    $events = Cache::remember('events_list',60,function() use ($query){
        return $query->paginate(10);
    });

    return response()->json($events);
}

public function show($id)
{
    $event = Event::with('tickets')->findOrFail($id);

    return response()->json($event);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'title'=>'required|string|max:255',
        'description'=>'required|string',
        'date'=>'required|date',
        'location'=>'required|string|max:255'
    ]);

    $event = Event::create([
        'title'=>$validated['title'],
        'description'=>$validated['description'],
        'date'=>$validated['date'],
        'location'=>$validated['location'],
        'created_by'=>auth()->id()
    ]);

    return response()->json($event,201);
}

public function update(Request $request,$id)
{
    $event = Event::findOrFail($id);

    if($event->created_by != auth()->id()){
        return response()->json(['message'=>'Unauthorized'],403);
    }

    $validated = $request->validate([
        'title'=>'sometimes|string|max:255',
        'description'=>'sometimes|string',
        'date'=>'sometimes|date',
        'location'=>'sometimes|string|max:255'
    ]);

    $event->update($validated);

    return response()->json($event);
}

public function destroy($id)
{
    $event = Event::findOrFail($id);

    if($event->created_by != auth()->id()){
        return response()->json(['message'=>'Unauthorized'],403);
    }

    $event->delete();

    return response()->json(['message'=>'Event deleted']);
}

}