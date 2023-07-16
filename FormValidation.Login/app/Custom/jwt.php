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
