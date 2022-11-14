<?php
namespace App\Controller\Admin;

use App\Utils\View;

class Page 
{

    private static $modules = [
        'Home'  => [
            'label' => 'Home',
            'link'  => URL.'/admin'
        ],

        'Depoimentos'  => [
            'label' => 'Depoimentos',
            'link'  => URL.'/admin/depoimentos'
        ],

        'Usuarios'  => [
            'label' => 'Usuarios',
            'link'  => URL.'/admin/usuarios'
        ]
    ];

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
            'menu'      => self::renderMenu($currentModule),
            'content'   => $content
        ]);
        return self::renderMainLayout($title, $contentPanel);
    }


    private static function renderMenu($currentModule)
    {
        $links = '';

        foreach(self::$modules as $hash => $module) {
            $links .= View::render('admin/menu/link', [
                'label'     => $module['label'],
                'link'      => $module['link'],
                'current'   => $hash == $currentModule ? 'text-danger' : ''
            ]);
        }
        return View::render('admin/menu/box', [
            'links'  => $links
        ]);
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
            $links .= View::render('admin/pagination/link', [
                'page'    => $button['pagina'],
                'link'    => $link,
                'active'  => $button['current'] ? 'active' : ''  
            ]);
        }

        return View::render('admin/pagination/box', [
            'links' => $links
        ]);
   
    }
}