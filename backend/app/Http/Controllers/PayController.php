<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pay;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PayController extends Controller
{
    public function index()
    {
        $pays = Pay::with('event')->get();
        return response($pays,Response::HTTP_OK); 
    }

    public function store(Request $request)
    {
        $event1 = Event::with('Client')->findOrFail($request->get('event_id'));
        $total= $event1->total_cost;
        $pago = $request->amount;
        $deuda= $total - $pago;
        if($deuda < 0)return response(['mesg'=>'No se puede crear el pago'],Response::HTTP_INTERNAL_SERVER_ERROR);
        $pay = Pay::create([
            'pay_date'=> $request->pay_date,
            'amount' => $request->amount,
            'pay_type'=> $request->pay_type,
            'pay_status'=> $request->pay_status,
            'deuda' => $deuda,
            'event_id' => $request->get('event_id'),
        ]);
        if ($deuda == 0) {
            $event1->update(['status'=>'Completado']);
            $event1->save();
            $pay->update(['pay_status'=>'Completado']);
            $pay->save();
        }
        return response($pay,Response::HTTP_CREATED);
    }

    public function show(Pay $pay)
    {
        $pay = Pay::with('event')->findOrFail($pay->id);
        return response($pay,Response::HTTP_OK);
    }

    public function update(Request $request, Pay $pay)
    {
        $pay->update($request->all());
        return response($pay,Response::HTTP_OK);
    }

    public function destroy(Pay $pay)
    {
        $pay->delete();
        return response(['msg'=> 'Pago eliminado correctamente'],Response::HTTP_NO_CONTENT);
    }
}
