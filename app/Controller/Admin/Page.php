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
}