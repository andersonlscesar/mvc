<?php
namespace App\Controller\Admin;

use App\Utils\View;

class Page 
{
    public static function renderMainLayout($title, $content)
    {
        return View::render('admin/page', [
            'title'     => $title,
            'content'   => $content
        ]);
    }


    public static function renderPanel($title, $content, $currentModule)
    {
        $contentPanel = View::render('admin/panel', [
            'menu'      => 'olá, mundo',
            'content'   => $content
        ]);
        return self::renderMainLayout($title, $contentPanel);
    }
}