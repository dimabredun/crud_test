<?php

namespace App\Controller;

use App\Service\MysqlRecordStorage;
use App\Service\SqLiteRecordStorage;
use PDO;

class TestController
{
    private array $configuration;
    private MysqlRecordStorage $mysqlCrud;
    private SqLiteRecordStorage $sqliteCrud;
    private ?PDO $pdo = null;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getPDO(): PDO
    {
        if($this->pdo === null) {
            $this->pdo = new PDO(
                $this->configuration['dsn'],
                $this->configuration['user'],
                $this->configuration['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            var_dump($this->configuration);
//            die;
        }

        return $this->pdo;
    }

    public function CrudMysql(): MysqlRecordStorage
    {
        $this->mysqlCrud = new MysqlRecordStorage($this->getPDO());

        return $this->mysqlCrud;
    }

    public function CrudSqlite(): SqLiteRecordStorage
    {
        $this->sqliteCrud= new SqLiteRecordStorage($this->getPDO());

        return $this->sqliteCrud;
    }
}