<?php

namespace App\Model;

class Record
{
    const ID = 'id';
    const NAME = 'name';
    const AUTHOR = 'author';
    const GENRE = 'genre';

    public ?int $id;
    public string $name;
    public string $author;
    public string $genre;

    public function __construct(string $name = '', string $author = '', string $genre = '')
    {
        $this->name = $name;
        $this->author = $author;
        $this->genre = $genre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }
}