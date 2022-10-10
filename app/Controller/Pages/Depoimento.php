<?php
namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Depoimento as EntityDepoimento;
use App\Common\Pagination;

class Depoimento extends Page
{
    public static function renderContent($request) 
    {
   
        $content = View::render('pages/depoimento', [
            'depoimentos'   => self::getTestimonyItems()
        ]);
        return parent::renderMainLayout('Depoimento', $content);
    }

    public static function insertTestimony($request)
    {
        $postVars = $request->getPostVars();
        $obTestimony = new EntityDepoimento;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
  
        $obTestimony->cadastrar();
        header('location: '.getenv('URL').'/depoimentos');
        exit;
    }

    private static function getTestimonyItems()
    {
        $itens = '';
        $obTestimony = new EntityDepoimento;
        $depoimentos = $obTestimony->getTestimonies(null, ' id DESC ');
        $quantidadeDepoimentos = EntityDepoimento::getQtdTestimonies();
  
        // $pagination = new Pagination($quantidadeDepoimentos, );

        foreach($depoimentos as $depoimento) {
            $itens .= View::render('pages/testimonies/itens', [
                'nome'      => $depoimento->nome,
                'mensagem'  => $depoimento->mensagem,
                'data'      => date("d/m/Y à\s H:i:s", strtotime($depoimento->data))
            ]);
        }
 

        return $itens;
    }
}