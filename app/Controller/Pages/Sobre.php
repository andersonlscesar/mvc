<?php
namespace App\Controller\Pages;

use App\Utils\View;

class Sobre extends Page
{
    public static function renderContent() 
    {
        $content = View::render('pages/sobre');

        return parent::renderMainLayout('Sobre', $content);
    }
}