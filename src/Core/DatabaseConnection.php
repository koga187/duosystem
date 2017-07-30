<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 2:08 PM
 */

namespace Duosystem\Core;


use Doctrine\DBAL\Driver\PDOException;
use Doctrine\DBAL\Driver\PDOStatement;

class DatabaseConnection
{
    private $driver   = 'pdo_mysql';
    private $host     = '127.0.0.1';
    private $port     = '3306';
    private $user     = 'root';
    private $password = 'root';
    private $dbname   = 'teste_duosystem';
    /**
     * @var \PDO $connection
     */
    private $connection;

    /**
     * @return null|static
     */
    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * @param string $sql
     * @param array $args
     * @return \PDOStatement
     * @throws \ErrorException
     */
    public function query(string $sql, array $args = []) {
        $stmt = $this->connection->prepare($sql);

        if (!$stmt->execute($args)) {
            throw new \ErrorException('Problemas ao executar a query pr favor verifique o log: ' . $stmt->queryString, 9999, 9, __FILE__, __LINE__);
        }

        return $stmt;
    }

    protected function __construct()
    {
        $this->getConnection();
    }

    private function __clone()
    {

    }

    private function __wakeup()
    {

    }

    /**
     * @return \PDO
     */
    private function getConnection(): \PDO {
        $this->connection =  new \PDO("mysql:dbname=$this->dbname;host=$this->host", $this->user, $this->password);

        return $this->connection;
    }

    public function getLastInsertId() {
        return $this->connection->lastInsertId();
    }
}