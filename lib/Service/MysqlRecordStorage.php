<?php

namespace App\Service;

use App\Interface\CrudInterface;
use App\Model\Record;
use PDO;
use Exception;

class MysqlRecordStorage implements CrudInterface
{
    private ?PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        $records = [];

        try {
            $statement = $this->pdo->prepare('SELECT * FROM record;');
            $statement->execute();
            $dbRecords = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dbRecords as $dbRecord) {
            $record = new Record(
                $dbRecord[Record::NAME],
                $dbRecord[Record::AUTHOR],
                $dbRecord[Record::GENRE]
            );
            $record->setId((int) $dbRecord[Record::ID]);

            $records[] = $record;
        }} catch (\PDOException $exception) {
            echo 'Operation failed - '. $exception->getMessage();
        }

        return $records;
    }

    public function save($name, $author, $genre): bool
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO record (name, author, genre) 
                    VALUES ('$name', '$author', '$genre')");

        $result = $statement->execute();

        if(!$result) {
            throw new Exception('Data is not in DB');
        }

        return $result;
    }

    /** This update example dedicated to changing values in whole row */
    public function update($name, $author, $genre, $id): bool
    {
        try {
            $statement = $this->pdo->prepare("UPDATE record SET name='$name', author='$author', genre='$genre' WHERE id=$id");
            $statement->execute();
        } catch (\PDOException $exception) {
            echo 'Operation failed - '. $exception->getMessage();
        }

        return true;
    }

    public function delete($id): bool
    {
        try {
            $statement = $this->pdo->prepare("DELETE FROM record WHERE id=$id");
            $statement->execute();
        } catch (\PDOException $exception) {
            echo 'Operation failed - '. $exception->getMessage();
        }

        return true;
    }
}