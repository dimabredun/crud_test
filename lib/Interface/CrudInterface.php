<?php

namespace App\Interface;

interface CrudInterface
{
    public function getAll(): array;

    public function save($name, $author, $genre): bool;

    public function update($name, $author, $genre, $id): bool;

    public function delete($id): bool;
}