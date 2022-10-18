<?php
namespace App\Session\Admin;

class Login
{

    // Inicia a sessão
    private static function init()
    {
        if(session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    //Cria o login do usuário
    public static function login($obUser)
    {
        self::init();
        $_SESSION['admin']['usuario'] = [
            'id'    => $obUser->id,
            'nome'  => $obUser->nome,
            'email' => $obUser->email
        ];

        return true;

    }

    public static function isLogged()
    {
        self::init();
        return isset($_SESSION['admin']['usuario']['id']);
    }

    public static function logout()
    {
        self::init();
        session_destroy();
        session_unset();
        return true;
    }
}