<?php

class User
{
    private string $email;
    private string $nickname;
    private string $password;
    private string $avatar;
    private int $id;
    private bool $isAdministrator;

    public function __construct(string $nickname, bool $isAdministrator = false)
    {
        $this->nickname = $nickname;
        $this->isAdministrator = $isAdministrator;
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

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function isAdministrator(): bool
    {
        return $this->isAdministrator;
    }

    public function toJson(): string
    {
        return json_encode([
            'email' => $this->email,
            'nickname' => $this->nickname,
            'avatar' => $this->avatar,
            'id' => $this->id
        ]);
    }

}