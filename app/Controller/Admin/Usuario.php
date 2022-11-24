<?php
namespace App\Controller\Admin;

use App\Utils\View;
use App\Controller\Admin\Alert;
use App\Model\Entity\Usuario as EntityUsuario;
use App\Common\Pagination;

class Usuario extends Page
{

    private static function getStatus($request)
    {
        $queryParams = $request->getQueryParams();
        if(!isset($queryParams['status'])) return '';

        switch($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Usuário criado com sucesso');
                break;
            case 'updated':
                return Alert::getSuccess('Usuário atualizado com sucesso');
                break;
            case 'deleted':
                return Alert::getSuccess('Usuário excluido com sucesso');
                break;
            
        }
    }

    
    public static function renderContent($request)
    {
        $content = View::render('admin/modules/usuarios/index', [
            'itens' => self::getUserItems($request, $pagination),
            'pagination' => Parent::getPagination($request, $pagination),
            'status'    =>  self::getStatus($request)
        ]);
        return Parent::renderPanel('Usuários - ADM', $content, 'Usuarios');
    }

    private static function getUserItems($request, &$pagination)
    {
        $itens = '';
        $obTestimony = new EntityUsuario;
        $qtdUsuarios = EntityUsuario::getQtdUsers();
        $get = $request->getQueryParams();  
        $pagination = new Pagination($qtdUsuarios, $get['pagina'] ?? 1);
        $usuarios = $obTestimony->getUsers(null, ' id DESC ', $pagination->slice());        

        foreach($usuarios as $usuario) {
            $itens .= View::render('admin/modules/usuarios/item', [
                'id'        => $usuario->id,
                'nome'      => $usuario->nome,
                'email'     => $usuario->email
            ]);
        }
 

        return $itens;
    }


    public static function getNewUser($request)
    {
        $content = View::render('admin/modules/usuarios/form', [
           'title'  => 'Cadastrar Usuário',
           'nome'   => '',
           'email'  => '',
           'status' => ''
        ]);
        return Parent::renderPanel('Cadastrar Usuários - ADM', $content, 'Depoimentos');
    }

    public static function setNewUser($request)
    {
        $post = $request->getPostVars();
        $user = new EntityUsuario;
        $user->nome = $post['nome'] ?? '';
        $user->email = $post['email'] ?? '';
        $user->senha = password_hash($post['senha'], PASSWORD_DEFAULT);
        $user->cadastrar();
        $request->getRouter()->redirect('admin/usuarios/'.$user->id.'/edit?status=created');
    }

    public static function getEditUser($request, $id)
    {
        $user = EntityUsuario::getUserById($id);
        
        if(!$user instanceof EntityUsuario) {
            $request->getRouter()->redirect('admin/usuarios');
        }
        
        $content = View::render('admin/modules/usuarios/form', [
           'title'  => 'Editar usuário',
           'nome'   => $user->nome,
           'email'  => $user->email,
           'status' => self::getStatus($request)
        ]); 
        return Parent::renderPanel('Editar Usuários - ADM', $content, 'Usuarios');
    }

    public static function setEditUser($request, $id)
    {
        $user = EntityUsuario::getUserById($id);
        
        if(!$user instanceof EntityUsuario) {
            $request->getRouter()->redirect('admin/usuarios');
        }
        
        $post = $request->getPostVars();
        $user->nome = $post['nome'] ?? $user->nome;
        $user->email = $post['email'] ?? $user->email;
        $user->senha = password_hash($post['senha'], PASSWORD_DEFAULT);

        $user->atualizar($id);
        $request->getRouter()->redirect('admin/usuarios/'.$user->id.'/edit?status=updated');

    }


    public static function getDeleteUser($request, $id)
    {
        $user = EntityUsuario::getUserById($id);
        
        if(!$user instanceof EntityUsuario) {
            $request->getRouter()->redirect('admin/usuarios');
        }
        
        $content = View::render('admin/modules/usuarios/delete', [          
           'nome'   => $user->nome
        ]); 
        return Parent::renderPanel('Excluir Usuários - ADM', $content, 'Usuario');
    }

    public static function setDeleteUser($request, $id)
    {
        $user = EntityUsuario::getUserById($id);
        
        if(!$user instanceof EntityUsuario) {
            $request->getRouter()->redirect('admin/usuarios');
        }
      
        $user->delete($id);
        $request->getRouter()->redirect('admin/usuarios?status=deleted');

    }


}