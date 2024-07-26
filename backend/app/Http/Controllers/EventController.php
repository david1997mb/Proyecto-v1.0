<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::select('events.*', 'users.name as user', 'clients.name as client')
            ->join('clients', 'clients.id', '=', 'events.client_id')
            ->join('users', 'users.id', '=', 'clients.user_id')
            ->paginate(10);

        return response()->json($events);
 
    }

    public function store(Request $request, Event $event)
    {
        $rules = [
            'client_id' => 'required|numeric',
            'guests' => 'nullable|integer'
        ];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $event = new Event($request->input());
        $event->saldo = $request->cost;
        $event->save();
        $areas = $request->input('areas');
        $event->areas()->attach($areas);
        return response()->json([
            'status'=>true,
            'message'=> 'Evento Creado Correctamente',
            'data'=> $event,
            'areas'=> $areas
        ],200);
    }

    public function show($eventId)
    {
        $event = Event::with(['areas', 'client.user', 'pays'])->find($eventId);
        if (!$event) {
            return response()->json(['status' => false, 'message' => 'Evento no encontrado'], 404);
        }
        return response()->json(['status' => true, 'data' => $event], 200);
    }

    public function update(Request $request, Event $event)
    {
        $rules = [
            'type' => 'required|in:Matrimonio,Cumpleaños,Reuniones,Bautizo',
            'event_date' => 'required|date',
            'areas' => 'required|array', // Asegúrate de que el campo 'areas' sea un arreglo
            'areas.*' => 'exists:areas,id' // Asegúrate de que cada ID de área exista en la tabla de áreas
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        try {
            // Actualizar el evento con los datos proporcionados
            $event->update($request->all());

            // Actualizar las áreas asociadas al evento
            $event->areas()->sync($request->input('areas'));

            return response()->json([
                'status' => true,
                'message' => 'Evento actualizado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar el evento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Event $event)
    {
        try {
            // Eliminar las relaciones entre el evento y las áreas asociadas
            $event->areas()->detach();
    
            // Eliminar el evento
            $event->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Evento eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al eliminar el evento: ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function eventsbyclients() {
        $events = Event::select(DB::raw('count(events.id) as count, clients.name, events.type'))
            ->rightJoin('clients','clients.id','=','events.client_id')
            ->groupBy('clients.name', 'events.type')
            ->get();
        return response()->json($events);
    }
             
    public function all() {
        $events = Event::select('events.*', 'users.name as user', 'clients.name as client')
            ->join('clients', 'clients.id', '=', 'events.client_id')
            ->join('users', 'users.id', '=', 'clients.user_id')
            ->get();

        return response()->json($events);
    }  
}
