<?php
namespace App\Controller\Admin;

use App\Utils\View;

class Alert 
{
    public static function getSuccess($mensagem)
    {
        return View::render('admin/alert/status', [
            'tipo'      => 'success',
            'mensagem'  => $mensagem
        ]);
    }

    public static function getError($mensagem)
    {
        return View::render('admin/alert/status', [
            'tipo'      => 'danger',
            'mensagem'  => $mensagem
        ]);
    }
}