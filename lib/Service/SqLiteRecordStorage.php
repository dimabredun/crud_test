<?php

namespace App\Service;

use App\Interface\CrudInterface;
use App\Model\Record;
use SQLite3;
use PDOException;
use PDO;

class SqLiteRecordStorage implementS CrudInterface
{
    private ?PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return Record[]
     */
    public function getAll(): array
    {
        $db = new SQLite3('/home/dima/record.db');

        $records = [];

        try {
            $results = $db->query( "SELECT * FROM record");

            while ($row = $results->fetchArray()) {
                $record = new Record(
                    $row[Record::NAME],
                    $row[Record::AUTHOR],
                    $row[Record::GENRE]
                );
                $record->setId((int) $row[Record::ID]);

                $records[] = $record;
            }

        } catch (PDOException $exception) {
            return "Data isn't loaded" . $exception->getMessage();
        }

        return $records;
    }

    public function save($name, $author, $genre): bool
    {
        $db = new \SQLite3('/home/dima/record.db');

        $insert = $db->query(
            "INSERT INTO record (name, author, genre) 
                    VALUES ('$name', '$author', '$genre')");

        if(!$insert) {
            throw new \PDOException('Data is not in DB');
        }

        return true;
    }

    /** This update example dedicated to changing values in whole row */
    public function update($name, $author, $genre, $id): bool
    {
        $db = new \SQLite3('/home/dima/record.db');

        try {
            $db->query("UPDATE record SET name='$name', author='$author', genre='$genre' WHERE id=$id");
        } catch (\PDOException $exception) {
            echo 'Operation failed - '. $exception->getMessage();
        }

        return true;
    }

    public function delete($id): bool
    {
        $db = new \SQLite3('/home/dima/record.db');

        try {
            $db->query("DELETE FROM record WHERE id=$id");
        } catch (\PDOException $exception) {
            echo 'Operation failed - '. $exception->getMessage();
        }

        return true;
    }
}