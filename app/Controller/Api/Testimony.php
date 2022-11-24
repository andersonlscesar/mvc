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

    public static function setNewTestimony($request)
    {
        $post = $request->getPostVars();
        if(!isset($post['nome']) || !isset($post['mensagem'])) {
            throw new \Exception('Os campos nome e mensagem são obrigatórios', 400);
        }
        // Novo depoimento

        $testimony = new EntityDepoimento;
        $testimony->nome = $post['nome'];
        $testimony->mensagem = $post['mensagem'];
        $testimony->cadastrar();
        return [
            'id'        => (int) $testimony->id,
            'nome'      => $testimony->nome,
            'mensagem'  => $testimony->mensagem,
            'data'      => $testimony->data
        ];
    }

    public static function setEditTestimony($request, $id)
    {
        if(!is_numeric($id)) {
            throw new \Exception('ID Inválido', 404);
        }
        
        $post = $request->getPostVars();
        $testimony = EntityDepoimento::getTestimoniesById($id);

        if(!$testimony instanceof EntityDepoimento) {
            throw new \Exception('Depoimento não encontrado', 404);
        }

        if(!isset($post['nome']) || !isset($post['mensagem'])) {
            throw new \Exception('Os campos nome e mensagem são obrigatórios', 400);
        }
        $testimony->nome = $post['nome'];
        $testimony->mensagem = $post['mensagem'];
        $testimony->atualizar($id);        
        return [
            'id'        => (int) $testimony->id,
            'nome'      => $testimony->nome,
            'mensagem'  => $testimony->mensagem,
            'data'      => $testimony->data
        ];
    }

    public static function setDeleteTestimony($id) 
    {
        if(!is_numeric($id)) {
            throw new \Exception('ID Inválido', 404);
        }
        $testimony = EntityDepoimento::getTestimoniesById($id);

        if(!$testimony instanceof EntityDepoimento) {
            throw new \Exception('Depoimento não encontrado', 404);
        }

        $testimony->delete($id);
        return [
            'success' => true
        ];
   
    }
    

    public static function getCurrentUser($request)
    {
        
    }
}