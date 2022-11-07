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
            'link'  => URL.'/depoimentos'
        ],

        'Usuarios'  => [
            'label' => 'Usuarios',
            'link'  => URL.'/usuarios'
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
}