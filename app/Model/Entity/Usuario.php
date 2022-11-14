<?php
namespace App\Model\Entity;

use PDO;
use App\Database\Database;

class Usuario
{
    public $id;
    public $nome;
    public $email;
    public $senha;

    public function cadastrar() 
    {
        $this->id = (new Database('usuarios'))->insert([
                                                            'nome'      => $this->nome,
                                                            'email'     => $this->email,
                                                            'senha'     => $this->senha
                                                          ]);
        return true;
    }

    public static function getUserByEmail($email)
    {
        return (new Database('usuarios'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }

    public static function getQtdUsers()
    {
        return (new Database('usuarios'))->select(null, null, null, 'COUNT(*) totalDepoimentos')->fetchObject()->totalDepoimentos;
    }

    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('usuarios'))->select($where, $order, $limit, $fields)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getUserById($id) 
    {
        return (new Database('usuarios'))->select('id = '.$id)->fetchObject(self::class);
    }

    public function atualizar($id) 
    {
     return (new Database('usuarios'))->update(' id = '.$id, [
                                                            'nome'      => $this->nome,
                                                            'email'     => $this->email,
                                                            'senha'     => $this->senha
                                                          ]);
        
    }

    public function delete($id)
    {
        return (new Database('usuarios'))->delete('id = '.$id);
    }
}