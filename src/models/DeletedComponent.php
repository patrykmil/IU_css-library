<?php
require_once 'Message.php';

class DeletedComponent
{
    private int $id;
    private string $name;
    private Message $message;
    private string $css;
    private string $html;

    public function __construct(int $id, string $name, Message $message, string $css = '', string $html = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->message = $message;
        $this->css = $css;
        $this->html = $html;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function setHtml(string $html): void
    {
        $this->html = $html;
    }

    public function getCss(): string
    {
        return $this->css;
    }

    public function setCss(string $css): void
    {
        $this->css = $css;
    }
}
