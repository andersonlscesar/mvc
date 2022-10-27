<?php
namespace App\Controller\Admin;

use App\Utils\View;
use App\Model\Entity\Usuario;
use App\Session\Admin\Login as SessionLogin;
use App\Controller\Admin\Alert;

class Login extends Page
{
    public static function renderContent($request) 
    {
        $gets = $request->getQueryParams();
        $status = isset($gets['error']) ? Alert::getError('Usuário ou senha incorretos') : '';
        $content = View::render('admin/login', [
            'status' => $status
        ]);
        return parent::renderMainLayout('Login', $content);
    }

    public static function setLogin($request)
    {
        $post = $request->getPostVars();
        $email = $post['email'] ?? '';
        $senha = $post['senha'] ?? '';

        $user = Usuario::getUserByEmail($email);

        if(!$user instanceof Usuario) {
            $request->getRouter()->redirect('admin/login?error=usuario-nao-cadastrado');
        }

        if(!password_verify($senha, $user->senha)) {
            $request->getRouter()->redirect('admin/login?error=senha-email-incorretos');
        }

        SessionLogin::login($user);
        $request->getRouter()->redirect('admin');
    }

    public static function setLogout($request)
    {
        SessionLogin::logout();
        $request->getRouter()->redirect('admin/login');
    }
}