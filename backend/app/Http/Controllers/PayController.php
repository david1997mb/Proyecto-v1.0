<?php

namespace App\Http\Controllers;

use App\Models\Pay;
use App\Models\Event;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
    public function index()
    {
        $pays = Pay::select('pays.*', 'events.type as event', 'clients.name as client')
                    ->join('events', 'events.id', '=', 'pays.event_id')
                    ->join('clients', 'clients.id', '=', 'events.client_id')
                    ->paginate(10);
        return response()->json($pays);
    }

    public function store(Request $request)
    {
        $rules = [
            'event_id' => 'required|exists:events,id',
            'amount' => 'required',
            'method' => 'required|in:Efectivo,Transferencia,Deposito,Tarjeta'
        ];

        $validator = Validator::make($request->input(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        try {
            DB::transaction(function () use ($request) {
                $event = Event::findOrFail($request->event_id);
                $pay = Pay::create($request->input());

                $event->saldo -= $request->amount;
                $event->save();

                if ($event->saldo <= 0) {
                    $event->status = 'Completado';
                    $event->save();
                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Pago Creado Correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al procesar el pago: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Pay $pay)
    {
        $event = $pay->event;
        $client = $event->client;
        return response()->json([
            'status' => true,
            'data' => [
                'pay' => $pay,
                'event' => $event,
                'client' => $client
            ]
        ], 200);
    }

    public function update(Request $request, Pay $pay)
    {
        $rules = [
            'event_id' => 'required|exists:events,id',
            'amount' => 'required',
            'pay_date' => 'required',
            'method' => 'required|in:Efectivo,Transferencia,Deposito,Tarjeta'
        ];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $pay->update($request->input());
        return response()->json([
            'status' => true,
            'message' => 'Pago Actualizado Correctamente'
        ],200);
    }

    public function destroy(Pay $pay)
    {
        $pay->delete();
        return response()->json([
            'status' => true,
            'message' => 'Pago Eliminado Correctamente'
        ],200);
    }

    public function paysbyevent() {
        $pays = Pay::select(DB::raw('count(pays.id) as count, events.type'))
            ->rightJoin('events','events.id','=','pays.event_id')
            ->groupBy('events.type')
            ->get();
        return response()->json($pays);
    } 

    public function all() {
        $pays = Pay::select('pays.*', 'events.type as event', 'clients.name as client')
            ->join('events', 'events.id', '=', 'pays.event_id')
            ->join('clients', 'clients.id', '=', 'events.client_id')
            ->get();
        return response()->json($pays);
    }
    
}
            