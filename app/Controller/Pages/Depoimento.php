<?php
namespace App\Controller\Pages;

use App\Utils\View;

class Depoimento extends Page
{
    public static function renderContent() 
    {
        $content = View::render('pages/depoimento');
        return parent::renderMainLayout('Depoimento', $content);
    }
}