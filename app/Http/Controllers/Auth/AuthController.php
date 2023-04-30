<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'     => ['required', 'string', 'min:6']
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(),], 422);
        } else {
            $user = User::create([

                'name'           => $request->name,
                'email'          => $request->email,
                'password'       => Hash::make($request->password)
            ]);

            if ($user->id) {
                return response()->json([
                    'access_token' => $user->createToken('auth-api')->accessToken
                ], 200);
            }
            return response()->json([
                'error' => 'Erro ao cadastrar usuário'
            ], 200);
        }
    }
}
