<?php
namespace App\Controller\Api;

class Api 
{
    public static function getDetails($request)
    {
        return [
            'nome'      => 'Api - MVC',
            'versao'    => 'v1.0.0',
            'autor'     => 'Anderson César',
            'email'     => 'andersonlscesar@gmail.com'
        ];
    }

    protected static function getPagination($request, $pagination)
    {
        $queryParams = $request->getQueryParams();
        $pages = $pagination->calculateButtons();

        return [
            'currentPage'  => isset($queryParams['pagina']) ? (int) $queryParams['pagina'] : 1,
            'totalPages'   => !empty($pages) ? count($pages) : 1
        ];
    }
}