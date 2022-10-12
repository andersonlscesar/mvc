<?php
namespace App\Database;

use Exception;
use PDOException;
use PDO;
use PDOStatement;

class Database
{
    private string $host;
    private string $name;
    private string $user;
    private string $pass;
    private string $table;
    private PDO $connection;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Retorna o HOST
     * @return string
     */

    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Define o host
     * @param string $host
     * @return void
     */

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * Retorna o nome da base de dados
     * @return string
     */

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Define o nome da base de dados
     * @param string $name
     * @return void
     */

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Retorna o usuário do banco de dados
     * @return string
     */

    public function getUser(): string 
    {
        return $this->user;
    }

    /**
     * Define o usuário do banco de dados
     * @param string $user
     * @return void
     */

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * Retorna a senha do bd
     * @return string
     */

    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * Define a senha do db
     * @param string $pass
     * @return void
     */

    public function setPass(string $pass): void 
    {
        $this->pass = $pass;
    }
    /**
     * Define a conexão com a base de dados
     * @return PDOStatment 
     * @throws PDOException
     */

    private function setConnection()
    {
        try {
            //Definindo os dados para conexão com o banco
            $this->setHost(getenv('DB_HOST'));
            $this->setName(getenv('DB_NAME'));
            $this->setUser(getenv('DB_USER'));
            $this->setPass(getenv('DB_PASS'));

            $host = $this->getHost();
            $name = $this->getName();
            $user = $this->getUser();
            $pass = $this->getPass();

            $this->connection = new PDO('mysql:host='.$host.';dbname='.$name, $user, $pass);  
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;

        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Executa os comandos sql
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */

    private function execute(string $query, array $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Cria dados no banco
     * @param array $values
     * @return int
     */

    public function insert(array $values = []): int
    {
        $fields = array_keys($values);
        $bind = array_pad([], count($fields), '?');
        $query = 'INSERT INTO '.$this->table.' ('.implode(', ', $fields).') VALUES ('.implode(', ', $bind).');';     
        $this->execute($query, array_values($values));
        return $this->connection->lastInsertId();
    }

    /**
     * Seleciona os dados no banco
     * @param strign $where
     * @param string $order
     * @param string $limit
     * @param string $fields

     * 
     */

    public function select(
                            string $where       = null,
                            string $order       = null,
                            string $limit       = null,
                            string $fields      = '*',
              
                            )
    {
        //Verificando se os parâmetros apresentam ausência de valor

        $where      = !is_null($where) ? ' WHERE '.$where : null;
        $order      = !is_null($order) ? ' ORDER BY '.$order : null;
        $limit      = !is_null($limit) ? ' LIMIT '.$limit : null;  
        $query = 'SELECT '.$fields.' FROM '.$this->table.''.$where.''.$order.''.$limit.';'; 
        return $this->execute($query);   
    }

   

    /**
     * Deleta um registro do banco
     * @param string $where
     */

    public function delete($where)
    {
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
        return $this->execute($query);
    }

    /**
     * Atualizar os registros
     * @param string $where
     * @param array $values
     */

    public function update($where, $values = [])
    {
        $fields = array_keys($values);
        $query = 'UPDATE '.$this->table.' SET '.(implode(' = ?, ', $fields)).' = ? WHERE '.$where; 
        return $this->execute($query, array_values($values));
    }

}