<?php
namespace App\Controller\Admin;
use App\Utils\View;
use App\Model\Entity\Usuario;

class Login extends Page
{
    public static function renderContent($request, $errorMessage = null) 
    {
        $status = !is_null($errorMessage) ? View::render('admin/login/status', [
            'mensagem' => $errorMessage
        ]) : '';
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
            $request->getRouter()->redirect('admin/login?status=usuario-nao-cadastrado');
        }

        if(!password_verify($senha, $user->senha)) {
            $request->getRouter()->redirect('admin/login?status=senha-email-incorretos');
        }

    }
}