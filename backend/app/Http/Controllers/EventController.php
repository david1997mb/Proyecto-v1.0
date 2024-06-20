<?php

namespace App\Http\Controllers;

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
        $event = new Event($request->all());
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
