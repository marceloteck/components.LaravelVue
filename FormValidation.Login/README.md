# LOGIN COM LARAVEL + VUE.JS

Projeto seguindo a regra de pastas e arquivos de configuração desse projeto:

- [Implementar o laravel 10 com o vue 3 (Passo a Passo)](https://github.com/marceloteck/Instalar-Laravel10-e-Vue3-Passo-a-Passo)


## VAMOS INSTALAR OS COMPONTENTES:

**JWT** para o LARAVEL

```
composer require firebase/php-jwt
```

**Pinia** Para o VUE.JS

```
npm install pinia
```

**Axios** Para o VUE.JS

```
npm install axios
```

## CRIANDO OS ARQUIVOS DE FORMA AUTOMATICA BAIXANDO OS COMPONENTES

Só execultar:

```
git clone https://github.com/marceloteck/components.LaravelVue.git
```

E depois que tiver baixado, entre na pasta ```FormValidation.Login``` copie as pastas lá dentro e cole no diretorio principal do seu projeto..
<br>


# Arquivos para configuração manual

## PRIMEIRO OS AQUIVOS VUE.JS

**Cole cada código nos arquivos correpondentes**


FILE: ```Resources/js/app.js``` 
<br>

Cole o código abaixo para conseguir usar o pinia no seu projeto

``` 
import pinia from './config/Pinia'; // Importando o arquivo pinia.js

// Usar o Pinia
app.use(pinia);

``` 

FILE: ```Resources/js/router.js``` Rotas do vue.js
<br>

Só lembrando que essa configuração deve ser realizada manualmente

```
import { UseAuthLogin } from '@/config/auth.js'; 


// Criar instância do roteamento
const router = createRouter({
    history: createWebHistory(),
    routes: [
        { 
            // COD ...
            meta: { 
                // COD ...
                auth:true  // DEFINIR variavel com nome: auth:true
                /* somente nas rotas que devem ser acessadas com LOGIN ATIVO */
            } 
        },
    ],
});


    router.beforeEach(async (to, from, next) => {
        if(to.meta?.auth){ // se auth for true ENTRA no if
            const auth = UseAuthLogin();
            if(auth.token && auth.user){ // se existir entra
                const isAuthenticated = await auth.checkToken();
                if(isAuthenticated) next(); // SE é autenticado acessa
                else next({name: 'login'}); // se não redireciona para ROTA LOGIN
            }else{ // se não redireciona para login
                next({name: 'login'});
            }
        }else{ // se o auth não for true, acessa normalmente sem LOGIN
            next();
        }
      });
```


### **_BOTÃO DE LOGOUT_**

```
<template  v-if="auth.isAuthenticated">
  Bem Vindo {{ auth.UserName }}
  <br>
  <button class="btn btn-info" @click="logout">Sair</button>
</template>
<template v-else>
Olá visitante
</template>

<script setup>
import { UseAuthLogin } from '@/config/auth.js';
const auth = UseAuthLogin();
function logout(){
    auth.clearLogout();
}
</script>
```



## AGORA OS AQUIVOS LARAVEL

Cole esse Rota no arquivo de rota do Laravel ```api.php```

```
use App\Http\Controllers\API\loginController;

Route::post('/loginUser', [loginController::class, 'Login']);
Route::get('/loginUser/verify', [loginController::class, 'verify']);
```

No arquivo ```.env``` deve inserir a seguinte linha, abaixo da sua conexão com banco de dados ou onde preferir.

``` 
JWT_KEY=defina_sua_key_aqui_qualquer_palavra_ou_numeros

```
<br>

O arquivo ```app/http/Controller/API/loginController.php``` será baixado no git clone.
O código encontra-se logo a baixo.
<br>

o Arquivo ```app/Custom/jwt.php```Será baixado pelo git clone. O código também estará logo abaixo.
<br>

### Criando uma chave para o TOKEN

Nesse exemplo abaixo, estamos usando random_bytes para gerar 32 bytes aleatórios e, em seguida, convertendo-os em uma string hexadecimal usando bin2hex.
<br>
É importante armazenar essa chave de forma segura, como em uma variável de ambiente ou em um arquivo de configuração não acessível ao público. Nunca a compartilhe publicamente ou a armazene em um local inseguro, pois isso comprometeria a segurança dos seus tokens JWT.

``` 
$key = bin2hex(random_bytes(32));
```


---

<br>
<br>

**_Somente para busca rápida_**
<br>


---

## ARQUIVOS PRESENTES NO ```git clone```

**Já são baixados configurados**


FILE: ```Resources/js/config/http.js```

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
<br>

FILE: ```login.vue```

```
<form @submit.prevent="Auth">
              <fieldset class="clearfix">
                  <p>
                      <span class="lock-icon"><i class="fa fa-user"></i></span>
                      <input type="email"  Placeholder="E-mail" v-model="user.email" required>
                  </p> 

                  <p>
                      <span class="lock-icon"><i class="fa fa-lock"></i></span>
                      <input type="password"  Placeholder="Senha" v-model="user.password" required>
                  </p> 
                  
                  <div>
                      <span style="width:48%; text-align:left;  display: inline-block;">
                          <a class="small-text" href="#">Recuperar Senha?</a> <br>
                          <router-link :to="{name: 'register'}" class="small-text">Cadastrar</router-link>
                      </span>
                      <span style="width:50%; text-align:right;  display: inline-block;">
                          <input type="submit" value="Login">
                      </span>
                      <br>
                  </div>

              </fieldset>
            </form>


<script setup>
import http from '@/config/http.js';
import { reactive } from 'vue';
import { UseAuthLogin } from '@/config/auth.js';
import { useRouter } from 'vue-router';

const authLogin = UseAuthLogin();
const router = useRouter();

const user = reactive({
  email: '',
  password: '',
  lembrarMe: false
});

const msg = reactive({
  errorLogin: ''
});

async function Auth() {
  try {
    const { data } = await http.post('/loginUser', user);
    if (data?.token) {
      authLogin.setToken(data.token);
      authLogin.setUser(data.user);
      router.push({ name: 'index.Home' });
    } else if (data?.error === true) {
      Swal.mixin({
        toast: true,
      }).fire({
        icon: (data.error == true) ? "error" : "success",
        title: data.message,
        customClass: {
          confirmButton: 'btn_Custom'
        }
      }).then((result) => {
        if (result.isConfirmed) { 
          user.email = '';
          user.password = '';
        }
      });
    }

  } catch (error) {
    console.log('Erro ao fazer login:', error?.response?.data);
  }
}
</script>
  
```
<br>

FILE: ```resources/js/config/auth.js```

```
import { computed, ref } from 'vue';
import { defineStore } from 'pinia';
import http from '@/config/http.js';
import { useRouter } from 'vue-router';

// exportar a const UserAuthLogin
export const UseAuthLogin = defineStore('auth', () => {
    const token = ref(localStorage.getItem('token'));
    const user = ref(JSON.parse(localStorage.getItem('user')));

    // armazenar o token no localStorage
    function setToken(tokenValue) {
        localStorage.setItem('token', tokenValue);
        token.value = tokenValue;
      }
    
      // armazenar o user no localStorage
      function setUser(userValue) {
        localStorage.setItem('user', JSON.stringify(userValue));
        user.value = userValue;
      }

      // verificar se o token é valido
      async function checkToken(){
        try {
          const tokenAuth = 'Bearer ' + token.value;
          const { data } = await http.get('/loginUser/verify',{
            headers: {
              Authorization: tokenAuth
            }
          });
          return data;
        } catch (error) {
          console.log(error.response.data);
        }
      }

      // se estiver logado
      const isAuthenticated = computed(() =>{
        return (token.value && user.value) ?? '';
      });

      const UserName = computed(() =>{
        return user.value.name ?? '';
      });

      // Logout de usuario
      const router = useRouter();
      function clearLogout(){
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        token.value = '';
        user.value = '';
        router.push({ name: 'login' });
      }

      // retornar as funções
      return {
        token,
        user,
        setToken,
        setUser,
        checkToken,
        isAuthenticated,
        UserName,
        clearLogout,
      };
});
```


FILE: ```resources/js/config/Pinia.js```

```
import { createPinia } from "pinia";
const pinia = createPinia({});

export default pinia;
```
<br>

FILE: ```app/http/Controller/API/loginController.php```

```
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
```
<br>

FILE: ```app/Custom/jwt.php```

```
<?php
namespace App\Custom;

use App\Models\User;
use Firebase\JWT\JWT as JWTfirebase;
use Firebase\JWT\Key;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

use Illuminate\Support\Facades\Request;

class jwt
{
    public static function validate()
    {
        $authorization = Request::header('Authorization');
        $key = $_ENV['JWT_KEY'] ?? '';
        
        try {
            $token = str_replace('Bearer ', '', $authorization);
            $decoded = JWTfirebase::decode($token, new Key($key, 'HS256')); 
            
            // Verificar a origem do token
            $clientIp = Request::ip();
            $tokenIp = $decoded->ip ?? '';
            if ($clientIp !== $tokenIp) {
                return response()->json('Acesso não autorizado, ip', 401);
            }
            
            // Verificar a validade do token
            $now = time();
            $expiration = $decoded->exp ?? 0;
            if ($now > $expiration) {
                return response()->json('Token expirado', 401);
            }
            
            // Verificar se o token foi emitido para um usuário específico 
            $userId = $decoded->user_id ?? '';
            $authenticatedUserId = auth()->user()->id ?? '';
            if ($authenticatedUserId !== $userId) {
                return response()->json('Acesso não autorizado, id', 401);
            }
            
            
            return response()->json($decoded, 200);
            
        } catch (BeforeValidException $exception) {
            return response()->json($exception->getMessage(), 401);
        } catch (ExpiredException $exception) {
            return response()->json($exception->getMessage(), 401);
        } catch (SignatureInvalidException $exception) {
            return response()->json($exception->getMessage(), 401);
        } catch (\Throwable $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    public static function create(User $data, $rememberMe = false)
    {
        $key = $_ENV['JWT_KEY'];
    
        $expiry = $rememberMe ? 60 * 24 * 60 * 60 : 12 * 60 * 60; // 60 dias ou 12 horas
    
        $payload = [
            'exp'  => time() + $expiry,
            'iat'  => time(),
            'data' => [
                'id' => $data['id'],
                'name' => $data['name'],
            ],
            'ip'   => $_SERVER['REMOTE_ADDR'],
        ];
    
        return JWTfirebase::encode($payload, $key, 'HS256');
    }
}

```























