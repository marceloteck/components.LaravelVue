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
