<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('users.*')
        ->paginate(10);
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'errors'=> $validator->errors()->all()
            ],400);
        }
        $user = new User($request->input());
        $user->save();
        return response()->json([
            'status'=>true,
            'message'=> 'Usuario Creado Correctamente'
        ],200);
    }

    public function show(User $user)
    {
        return response()->json(['status'=>true,'data'=>$user]);
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'errors'=> $validator->errors()->all()
            ],400);
        }
        $user->update($request->input());
        return response()->json([
            'status'=>true,
            'message'=> 'Usuario Actualizado Correctamente'
        ],200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status'=>true,
            'message'=> 'Usuario Eliminado Correctamente'
        ],200);
    }
    public function all() {
        $users = User::select('users.*')
        ->get();
        return response()->json($users);
    }
}
