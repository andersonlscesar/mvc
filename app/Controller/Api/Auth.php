<?php
namespace App\Controller\Api;

use App\Model\Entity\Usuario;
use Firebase\JWT\JWT;

class Auth extends Api
{
    public static function generateToken($request)
    {
        $post = $request->getPostVars();

        if(!isset($post['email']) || !isset($post['senha'])) {
            throw new \Exception('Os campos email e senha são obrigatórios', 400);
        }

        $user = Usuario::getUserByEmail($post['email']);

        if(!$user instanceof Usuario || !password_verify($post['senha'], $user->senha)) {
            throw new \Exception('Usuário ou senha incorretos', 404);
        }

        // payload
        $payload = [
            'email' => $user->email
        ];
   
        return [
            'token' => JWT::encode($payload, getenv('JWT_KEY'), 'HS256')
        ];
    }
}