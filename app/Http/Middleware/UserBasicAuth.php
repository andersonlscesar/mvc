<?php
namespace App\Http\Middleware;
use App\Model\Entity\Usuario;

class UserBasicAuth 
{

    private function getBasicAuthUser()
    {
        //Verifica a existencia dos dados de acesso
        if(!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])) {
            return false;
        }

        //Busca o usuário pelo email
        $obUser = Usuario::getUserByEmail($_SERVER['PHP_AUTH_USER']);
        if(!$obUser instanceof Usuario) {
            return false;
        }
        return password_verify($_SERVER['PHP_AUTH_PW'], $obUser->senha) ? $obUser : false;
    }


    private function basicAuth($request) 
    {   
        //verifica o usuário recebido
        if($obUser = $this->getBasicAuthUser()) {
            $request->user = $obUser;
            return true;
        }
        throw new \Exception('Usuário ou senha inválidos', 403);
    }


    public function handle($request, $next)
    {
        // realiza a validação do acesso via basic auth
        $this->basicAuth($request);
        return $next($request);
    }
}