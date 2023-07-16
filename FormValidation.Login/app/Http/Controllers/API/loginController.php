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
        
        if(!$user || !password_verify($request->password, $user->password)){
            return response()->json([
                'error' => true,  
                'message' => 'Email ou Senha estão incorretos! Tente novamente.'
            ]);
        }else{
            $token = jwt::create($user, $request->lembrarMe);
            return response()->json([
                'token' => $token,
                'user'  => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'rlbr' => $request->lembrarMe
                ]
            ]);  
        }
    }
}

