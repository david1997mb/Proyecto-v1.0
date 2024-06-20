<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Response($users,Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
            ]);
        $user = User::create($request->all());
        return Response($user,Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return Response(['error' => 'Usuario no Encontrado'],Response::HTTP_NOT_FOUND);
            }
        return Response($user,Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return Response(['error' => 'Usuario no Encontrado'],Response::HTTP_NOT_FOUND);
            }
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            ]);
        $user->update($request->all());
        return Response($user,Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return Response(['error' => 'Usuario no Encontrado'],Response::HTTP_NOT_FOUND);
            }
        $user->delete();
        return Response(['message' => 'Usuario Eliminado'],Response::HTTP_OK);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return Response(['error' => 'Credenciales Invalidas'], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $cookie = cookie('auth_token', $token, 60*24); 
        return Response(['Token' => $token], Response::HTTP_OK)
            ->withCookie($cookie); 
    }

    public function logout(){
        $cookie = Cookie::forget('auth_token');
        return Response(['message' => 'Sesion Cerrada'],Response::HTTP_OK);
    }
}
