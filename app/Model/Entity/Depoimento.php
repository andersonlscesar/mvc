<?php
namespace App\Model\Entity;

use PDO;
use App\Database\Database;

class Depoimento
{
    public $id;
    public $nome;
    public $mensagem;
    public $data;

    public function cadastrar() 
    {
        $this->data = date('Y-m-d H:i:s');
        $this->id = (new Database('depoimentos'))->insert([
                                                            'nome'      => $this->nome,
                                                            'mensagem'  => $this->mensagem,
                                                            'data'      => $this->data
                                                          ]);
        return true;
    }

    public function delete($id)
    {
        return (new Database('depoimentos'))->delete('id = '.$id);
    }

    public function atualizar($id) 
    {
     return (new Database('depoimentos'))->update(' id = '.$id, [
                                                            'nome'      => $this->nome,
                                                            'mensagem'  => $this->mensagem,
                                                            'data'      => $this->data
                                                          ]);
        
    }

    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('depoimentos'))->select($where, $order, $limit, $fields)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQtdTestimonies()
    {
        return (new Database('depoimentos'))->select(null, null, null, 'COUNT(*) totalDepoimentos')->fetchObject()->totalDepoimentos;
    }

    public static function getTestimoniesById($id) 
    {
        return (new Database('depoimentos'))->select('id = '.$id)->fetchObject(self::class);
    }
}