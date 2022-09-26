<?php
namespace App\Controller\Pages;

use App\Utils\View;

class Page
{
    public static function renderMainLayout($title, $content)
    {
        return View::render('layout/main', [
            'title'     => $title, 
            'content'   => $content,
            'header'    => self::renderHeader()
        ]);
    }


    private static function renderHeader()
    {
        return View::render('layout/header');
    }
}