<?php
namespace App\Custom;

use App\Models\User;
use Firebase\JWT\JWT as JWTfirebase;
use Firebase\JWT\Key;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class jwt
{
    public Static function validate()
    {
        $authorization = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $key = $_ENV['JWT_KEY'] ?? '';
        
        try {
            $token = str_replace('Bearer ', '', $authorization);
            $decoded = JWTfirebase::decode($token, new Key($key, 'HS256')); 
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

    public static function create(User $data)
    {
        $key = $_ENV['JWT_KEY'];
        //$key = 'MSHMSRTINASISTECCKMMSR';

        $payload = [
            'exp'  => time() + 1800,
            'iat'  => time(),
            'data' => $data
        ];

        return JWTfirebase::encode($payload, $key, 'HS256');
    }
}
