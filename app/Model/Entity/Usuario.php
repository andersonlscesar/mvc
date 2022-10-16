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

    public static function getUserByEmail($email)
    {
        return (new Database('usuarios'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }
}