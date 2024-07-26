<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Event;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
   public function index()
    {
        $events = Event::with('Client')->get();
        return response($events,Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $event = new Event([
            'reserve_date' => $request->reserve_date,
            'type' => $request->type,
            'event_day' => $request->event_day,
            'start' => $request->start,
            'finish' => $request->finish,
            'guests' => $request->guests,
            'total_cost' => $request->total_cost,
            'status' => $request->status,
            'client_id' => $request->client_id
        ]);
        $event->areas()->attach($request->areas);
        $event->save();
        return response($event,Response::HTTP_CREATED);
    }

    public function show(Event $event)
    {
        $event = Event::with('Client')->findOrFail($event->id);
        return response($event,Response::HTTP_OK);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->all());
        return response($event,Response::HTTP_OK);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response(['Mensage'=> 'Evento Eliminado'],Response::HTTP_NO_CONTENT);
    }
}
