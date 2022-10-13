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

    public static function getPagination($request, $pagination)
    {
        $buttons = $pagination->calculateButtons();
        //verifica a quantidade de páginas

        if(count($buttons) <= 1) return '';

        $links = '';

        //URL atual sem gets
        $url = $request->getRouter()->getCurrentURL();

        //GET
        $get = $request->getQueryParams();

        // Renderiza os links
        foreach($buttons as $button) {
      
            $get['pagina'] = $button['pagina'];

            $link = $url.'?'.http_build_query($get);

            //view
            $links .= View::render('pages/pagination/link', [
                'page'    => $button['pagina'],
                'link'    => $link,
                'active'  => $button['current'] ? 'active' : ''  
            ]);
        }

        return View::render('pages/pagination/box', [
            'links' => $links
        ]);
   
    }
}