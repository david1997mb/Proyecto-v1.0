<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
   public function index()
    {
        $clients = Client::with('User')->get();
        return response($clients,Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:clients',
            'phone' => 'required|string',
            'address' => 'required|string',
            ]);
        $client = Client::create($request->all());
        return response($client,Response::HTTP_CREATED);
    }

    public function show(Client $client)
    {
        return response($client,Response::HTTP_OK);
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:clients',
            'phone' => 'required|string',
            'address' => 'required|string',
            ]);
        $client->update($request->all());
        return response($client,Response::HTTP_OK);
    }
    public function destroy(Client $client)
    {
        $client->delete();
        return response(['mensage'=>'CLiente Eliminado Correctamente'],Response::HTTP_NO_CONTENT);
    }
}
