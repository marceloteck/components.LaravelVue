<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Custom\jwt;

class loginController extends Controller
{
    public function verify(){
        return JWT::validate();
    }
    public function Login(request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user){
            response()->json('Sem Autorização', 401);
        }
        if(!password_verify($request->password, $user->password)){
            response()->json('Sem Autorização', 401);
        }

        $token = jwt::create($user);

        return response()->json([
            'token' => $token,
            'user'  => [
                'id' => $user->id,
                'name' => $user->name
            ]
        ]);  
    }
}
