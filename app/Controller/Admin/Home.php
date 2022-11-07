<?php
namespace App\Controller\Admin;

use App\Utils\View;
use App\Controller\Admin\Alert;

class Home extends Page
{
    public static function renderContent($request)
    {
        $content = View::render('admin/modules/home/index', []);
        return Parent::renderPanel('HOME - ADM', $content, 'Home');
    }
}