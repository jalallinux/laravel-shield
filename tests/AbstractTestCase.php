<?php

namespace JalalLinuX\Shield\Tests;

use JalalLinuX\Shield\ShieldServiceProvider;
use Monolog\Test\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ShieldServiceProvider::class
        ];
    }

    protected function getUsers()
    {
        return [
            'default' => [
                password_hash('user1', PASSWORD_DEFAULT, ['cost' => 4]),
                password_hash('password1', PASSWORD_DEFAULT, ['cost' => 4]),
            ],
            'jalallinux' => [
                password_hash('user2', PASSWORD_DEFAULT, ['cost' => 4]),
                password_hash('password2', PASSWORD_DEFAULT, ['cost' => 4]),
            ],
        ];
    }
}
