<?php

namespace JalalLinuX\Shield;

class Shield
{
    protected string $currentUser;

    public function __construct(
        protected array $users
    ) {
    }

    public function verify(string|null $username, string|null $password, string|null $user = null): bool
    {
        if ($username === null || $password === null) {
            return false;
        }

        $users = $this->getUsers($user);

        foreach ($users as $user => $credentials) {
            if (
                password_verify($username, reset($credentials)) &&
                password_verify($password, end($credentials))
            ) {
                $this->currentUser = $user;

                return true;
            }
        }

        return false;
    }

    protected function getUsers(string $user = null): array
    {
        if ($user !== null) {
            return array_intersect_key($this->users, array_flip((array) $user));
        }

        return $this->users;
    }

    public function getCurrentUser(): string
    {
        return $this->currentUser;
    }
}
