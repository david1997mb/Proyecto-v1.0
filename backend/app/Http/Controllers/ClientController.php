<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::select('clients.*','users.name as username','users.lastname as userlast')
        ->join('users','users.id','=','clients.user_id')
        ->paginate(10);
        return response()->json($clients);
    }

    public function store(Request $request)
    {
        // Obtener el ID del usuario autenticado
        $user_id = auth()->user()->id;
    
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|max:80',
            'phone' => 'required|max:15',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }
    
        // Establecer el user_id antes de guardar el cliente
        $client = new Client($request->input());
        $client->user_id = $user_id;
        $client->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Cliente creado correctamente'
        ], 200);
    }
    

    public function show(Client $client)
    {
        return response()->json([
            'status' => true,
            'data' => $client
        ],200);
    }

    public function update(Request $request, Client $client)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
        ];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $client->update($request->input());
        return response()->json([
            'status' => true,
            'message' => 'Cliente Actualizado Correctamente'
        ],200);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json([
            'status' => true,
            'message' => 'Cliente Eliminado Correctamente'
        ],200);
    }
    public function clientsbyuser() {
        $clients = Client::select(DB::raw('count(clients.id) as count, users.name, users.lastname'))
            ->rightJoin('users','users.id','=','clients.user_id')
            ->groupBy('users.name','users.lastname')
            ->get();
        return response()->json($clients);
    }         
    public function all() {
        $clients = Client::select('clients.*',
        'users.name as user')
        ->join('users','users.id','=','clients.user_id')
        ->get();
        return response()->json($clients);
    }
}
