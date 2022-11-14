<?php
namespace App\Controller\Admin;

use App\Utils\View;
use App\Controller\Admin\Alert;
use App\Model\Entity\Depoimento as EntityDepoimento;
use App\Common\Pagination;

class Testimony extends Page
{

    private static function getStatus($request)
    {
        $queryParams = $request->getQueryParams();
        if(!isset($queryParams['status'])) return '';

        switch($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Depoimento criado com sucesso');
                break;
            case 'updated':
                return Alert::getSuccess('Depoimento atualizado com sucesso');
                break;
            case 'deleted':
                return Alert::getSuccess('Depoimento excluido com sucesso');
                break;
            
        }
    }

    
    public static function renderContent($request)
    {
        $content = View::render('admin/modules/testimonies/index', [
            'itens' => self::getTestimonyItems($request, $pagination),
            'pagination' => Parent::getPagination($request, $pagination),
            'status'    => !empty(self::getStatus($request)) ? self::getStatus($request) : ''
        ]);
        return Parent::renderPanel('Depoimentos - ADM', $content, 'Depoimentos');
    }

    private static function getTestimonyItems($request, &$pagination)
    {
        $itens = '';
        $obTestimony = new EntityDepoimento;
        $quantidadeDepoimentos = EntityDepoimento::getQtdTestimonies();
        $get = $request->getQueryParams();  
        $pagination = new Pagination($quantidadeDepoimentos, $get['pagina'] ?? 1);
        $depoimentos = $obTestimony->getTestimonies(null, ' id DESC ', $pagination->slice());        

        foreach($depoimentos as $depoimento) {
            $itens .= View::render('admin/modules/testimonies/item', [
                'id'        => $depoimento->id,
                'nome'      => $depoimento->nome,
                'texto'  => $depoimento->mensagem,
                'data'      => date("d/m/Y à\s H:i:s", strtotime($depoimento->data))
            ]);
        }
 

        return $itens;
    }


    public static function getNewTestimony($request)
    {
        $content = View::render('admin/modules/testimonies/form', [
           'title'  => 'Cadastrar depoimento',
           'nome'   => '',
           'texto'  => '',
           'status' => ''
        ]);
        return Parent::renderPanel('Cadastrar Depoimentos - ADM', $content, 'Depoimentos');
    }

    public static function setNewTestimony($request)
    {
        $post = $request->getPostVars();
        $testimony = new EntityDepoimento;
        $testimony->nome = $post['nome'] ?? '';
        $testimony->mensagem = $post['texto'] ?? '';
        $testimony->cadastrar();
        $request->getRouter()->redirect('admin/depoimentos/'.$testimony->id.'/edit?status=created');
    }

    public static function getEditTestimony($request, $id)
    {
        $testimony = EntityDepoimento::getTestimoniesById($id);
        
        if(!$testimony instanceof EntityDepoimento) {
            $request->getRouter()->redirect('admin/depoimentos');
        }
        
        $content = View::render('admin/modules/testimonies/form', [
           'title'  => 'Editar depoimento',
           'nome'   => $testimony->nome,
           'texto'  => $testimony->mensagem,
           'status' => self::getStatus($request)
        ]); 
        return Parent::renderPanel('Editar Depoimentos - ADM', $content, 'Depoimentos');
    }

    public static function setEditTestimony($request, $id)
    {
        $testimony = EntityDepoimento::getTestimoniesById($id);
        
        if(!$testimony instanceof EntityDepoimento) {
            $request->getRouter()->redirect('admin/depoimentos');
        }
        
        $post = $request->getPostVars();
        $testimony->nome = $post['nome'] ?? $testimony->nome;
        $testimony->mensagem = $post['texto'] ?? $testimony->mensagem;
        $testimony->atualizar($id);
        $request->getRouter()->redirect('admin/depoimentos/'.$testimony->id.'/edit?status=updated');

    }


    public static function getDeleteTestimony($request, $id)
    {
        $testimony = EntityDepoimento::getTestimoniesById($id);
        
        if(!$testimony instanceof EntityDepoimento) {
            $request->getRouter()->redirect('admin/depoimentos');
        }
        
        $content = View::render('admin/modules/testimonies/delete', [
          
           'nome'   => $testimony->nome,
           'texto'  => $testimony->mensagem
        ]); 
        return Parent::renderPanel('Excluir Depoimentos - ADM', $content, 'Depoimentos');
    }

    public static function setDeleteTestimony($request, $id)
    {
        $testimony = EntityDepoimento::getTestimoniesById($id);
        
        if(!$testimony instanceof EntityDepoimento) {
            $request->getRouter()->redirect('admin/depoimentos');
        }
      
        $testimony->delete($id);
        $request->getRouter()->redirect('admin/depoimentos?status=deleted');

    }
}