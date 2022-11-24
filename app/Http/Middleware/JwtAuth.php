<?php
namespace App\Http\Middleware;
use App\Model\Entity\Usuario;
use Firebase\JWT\JWT;

class JwtAuth 
{

    private function getJwtAuthUser($request)
    {
        //Verifica a existencia dos dados de acesso
        
        $headers = $request->getHeaders();
        $jwt = isset($headers['Authorization']) ? str_replace('Bearer', '', $headers['Authorization']) : '';
        $decode = (array) JWT::decode($jwt, getenv('JWT_KEY'), ['HS256']);
        $email = $decode['email'] ?? '';
        //Busca o usuário pelo email
        $obUser = Usuario::getUserByEmail($email);
 

        return $obUser instanceof Usuario ? $obUser : false;
    }


    private function auth($request) 
    {   
        //verifica o usuário recebido
        if($obUser = $this->getJwtAuthUser($request)) {
            $request->user = $obUser;
            return true;
        }
        throw new \Exception('Acesso negado', 403);
    }


    public function handle($request, $next)
    {
        // realiza a validação do acesso via basic auth
        $this->auth($request);
        return $next($request);
    }
}