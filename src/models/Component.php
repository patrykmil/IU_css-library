<?php

require_once 'User.php';
require_once 'Tag.php';

class Component
{
    private int $id;
    private string $name;
    private string $set;
    private string $type;
    private string $color;
    private array $tags;
    private int $likes;
    private string $css;
    private string $html;
    private User $author;
    private ?bool $isLiked = null;

    public function __construct(
        string $name,
        string $set,
        string $type,
        string $color,
        array  $tags,
        int    $likes,
        string $css,
        string $html,
        User   $author,
        int    $id = -1
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->set = $set;
        $this->type = $type;
        $this->color = $color;
        $this->tags = $tags;
        $this->likes = $likes;
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

    public function getLikes(): int
    {
        return $this->likes;
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

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setLiked(bool $isLiked): void
    {
        $this->isLiked = $isLiked;
    }

    public function isLiked(): ?bool
    {
        return $this->isLiked;
    }

    public function changeLiked(): bool
    {
        $this->isLiked = !$this->isLiked;
        return $this->isLiked;
    }

    public function toJson(): string
    {
        return json_encode([
            'id' => $this->id,
            'name' => $this->name,
            'set' => $this->set,
            'type' => $this->type,
            'color' => $this->color,
            'tags' => array_map(fn($tag) => $tag->toJson(), $this->tags),
            'likes' => $this->likes,
            'css' => $this->css,
            'html' => $this->html,
            'author' => $this->author->toJson()
        ]);
    }
}