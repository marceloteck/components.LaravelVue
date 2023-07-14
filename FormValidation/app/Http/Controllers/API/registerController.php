<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Exceptions\RegisterValidation;

class registerController extends Controller
{

    public function Register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);
        
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return response()->json([
                'sucesso' => true, 
                'message' => 'Cadastrado com sucesso!'
            ]);
        
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();

            //captura os erros e define em uma variavel
            $nameError = $errors->first('name');
            $emailError = $errors->first('email');
            $passwordError = $errors->first('password');

            // cria um objeto da class RegisterValidation do Exceptions
            $RegisterValidation = new RegisterValidation();
            
            // verifica os erros e mostra as mesnagens da função handleError() 
            if ($nameError) {
                return $RegisterValidation->handleError('name');
            }
            
            if ($emailError) {
                
                if (User::where('email', $request->email)->exists() || $errors->has('email', 'unique')) 
                {
                    return $RegisterValidation->handleError('email_unique');
                } 
                elseif ($errors->has('email', 'email')) 
                {
                    return $RegisterValidation->handleError('email_invalid');
                }
            }
            
            if ($passwordError) {
                return $RegisterValidation->handleError('password');
            }            
        }
    }
}
