<?php

class User {
    private string $email;
    private string $nickname;
    private string $password;
    private int $id;

    public function __construct(string $email, string $nickname, string $password, ?int $id = -1) {
        $this->email = $email;
        $this->nickname = $nickname;
        $this->password = $password;
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}