<?php

namespace models;
use User;

class Component
{
    private int $id;
    private string $name;
    private string $set;
    private string $type;
    private string $color;
    private array $tags;
    private array $interactions;
    private string $css;
    private string $html;
    private User $author;

    public function __construct(string $name, string $set, string $type, string $color, array $tags, array $interactions, string $css, string $html, User $author ,int $id = -1)
    {
        $this->id = $id;
        $this->name = $name;
        $this->set = $set;
        $this->type = $type;
        $this->color = $color;
        $this->tags = $tags;
        $this->interactions = $interactions;
        $this->css = $css;
        $this->html = $html;
        $this->author = $author;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSet(): string
    {
        return $this->set;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getColor(): string
    {
        return $this->color;
    }
    public function getTags(): array
    {
        return $this->tags;
    }

    public function getInteractions(): array
    {
        return $this->interactions;
    }

    public function getCss(): string
    {
        return $this->css;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

}