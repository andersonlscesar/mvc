<?php
namespace App\Controller\Pages;

use App\Utils\View;

class Home extends Page
{
    public static function renderContent() 
    {
        $content = View::render('pages/home', [
            'nome'  => 'Anderson'
        ]);

        return parent::renderMainLayout('Home', $content);
    }
}