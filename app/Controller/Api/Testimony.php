<?php
namespace App\Controller\Api;
use App\Model\Entity\Depoimento as EntityDepoimento;
use App\Common\Pagination;



class Testimony extends Api 
{

    private static function getTestimonyItems($request, &$pagination)
    {
        $itens = [];
        $obTestimony = new EntityDepoimento;
        $quantidadeDepoimentos = EntityDepoimento::getQtdTestimonies();
        $get = $request->getQueryParams();  
        $pagination = new Pagination($quantidadeDepoimentos, $get['pagina'] ?? 1);
        $depoimentos = $obTestimony->getTestimonies(null, ' id DESC ', $pagination->slice());        

        foreach($depoimentos as $depoimento) {
            $itens[] =  [
                'id'        => (int) $depoimento->id,
                'nome'      => $depoimento->nome,
                'mensagem'  => $depoimento->mensagem,
                'data'      => $depoimento->data
            ];
        }
 

        return $itens;
    }


    public static function getTestimonies($request)
    {
        return [
            'depoimentos'   => self::getTestimonyItems($request, $pagination),
            'pagination'    => parent::getPagination($request, $pagination)
        ];
    }

    public static function getTestimony($request, $id)
    {
        if(!is_numeric($id)) {
            throw new \Exception('ID inválido', 400);
        }
        $testimony = EntityDepoimento::getTestimoniesById($id);
        
        if(!$testimony instanceof EntityDepoimento) {
            throw new \Exception('O depoimento não foi encontrado', 404);
        }
        return  [
            'id'        => (int) $testimony->id,
            'nome'      => $testimony->nome,
            'mensagem'  => $testimony->mensagem,
            'data'      => $testimony->data
        ];

    }
}