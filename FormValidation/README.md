<br>
<div align="center">
  
[Voltar ao git principal](https://github.com/marceloteck/LaravelVue/tree/main) 

</div>

<br>

# Validação de cadastro de usuario com Vue.js + Laravel

Cole esse Rota no arquivo de rota do Laravel ```api.php```

```
Route::post('/registerUser', [registerController::class, 'Register']);
Route::post('/loginUser', [registerController::class, 'Login']);
```

E execulte o git ou baixe o repositorio:

```
git clone https://github.com/marceloteck/LaravelVue.git
```

E depois que tiver baixado, entre na pasta ```FormValidation``` copie as pastas lá dentro e cole no diretorio principal do seu projeto..
<br>

**As pastas estão seguindo o projeto falado nesse link abaixo:**
<br>


- [Implementar o laravel 10 com o vue 3 (Passo a Passo)](https://github.com/marceloteck/Instalar-Laravel10-e-Vue3-Passo-a-Passo)


## CÓDIGO FONTE DE CADA ARQUIVO:

**FILE: registerController.php**

```
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


```
<br>

**FILE: RegisterValidation.php**

```
<?php

namespace App\Exceptions;

use Exception;

class RegisterValidation extends Exception
{
    public function handleError($errorType)
{
    switch ($errorType) {
        case 'string': // nome do usuario em string
            return response()->json([
                'error' => true,
                'message' => 'Nome inválido!'
            ]);
        case 'email_unique': // email unico no BD
            return response()->json([
                'error' => true,
                'message' => 'Este e-mail já está cadastrado!'
            ]);
        case 'email_invalid': // email invalido
            return response()->json([
                'error' => true,
                'message' => 'E-mail inválido!'
            ]);
        case 'password': // validação da senha
            return response()->json([
                'error' => true,
                'message' => 'Senha insegura, deve ter no mínimo 8 caracteres!'
            ]);
        default: // caso não encontre o erro
            return response()->json([
                'error' => true,
                'message' => 'Verifique se tem algum campo incorreto!'
            ]);
    }
}

}

```

<br>

**FILE: http.js**

```
import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json'
    }
});

export default axiosInstance;
```

**FILE: register.vue**

```
<template>
    <div class="main">       
            <div class="container">
              <div style="text-align: center;">
                  <div class="middle">
                    <div id="login">

                        <fieldset class="clearfix">                    
                            <form @submit.prevent="cadastarUser">
                              <p>
                                  <span class="lock-icon"><i class="fa fa-user"></i></span>
                                  <input type="text"  Placeholder="Usuário" id="name" v-model="user.name" required>
                              </p> 
                              <p>
                                  <span class="lock-icon"><i class="fa fa-user"></i></span>
                                  <input type="text"  Placeholder="Email" id="email" v-model="user.email" required>
                              </p> 
                              <p>
                                  <span class="lock-icon"><i class="fa fa-lock"></i></span>
                                  <input type="password"  Placeholder="Senha" id="password"  v-model="user.password" required>
                              </p> 
                              <p>
                                  <span class="lock-icon"><i class="fa fa-lock"></i></span>
                                  <input type="password"  Placeholder="Repetir Senha">
                              </p> 
                            <div>
                                <span style="width:48%; text-align:left;  display: inline-block;">
                                    <a class="small-text" href="/login">Login</a>
                                </span>
                                <span style="width:50%; text-align:right;  display: inline-block;">
                                    <input type="submit" value="Cadastrar">
                                </span>
                                <br>
                            </div>
                          </form>
                        </fieldset>
                    </div> <!-- end login -->
                    <div class="logo">
                        Logo                    
                        
                    </div>
                  </div>
                </div>
          </div>
        </div>
    
    </template>
<script setup>
import http from '../../config/http.js';
import { reactive } from 'vue';

const user = reactive({
  name: '',
  email: '',
  password: ''
});

async function cadastarUser(){
  try {
    const {data} = await http.post('/registerUser', user);
    console.log(data);
  } catch (error) {
    console.log(error?.response?.data);
  }
}
</script>

```
