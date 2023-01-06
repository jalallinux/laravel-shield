<?php

namespace JalalLinuX\Shield\Tests;

use JalalLinuX\Shield\Shield;
use ReflectionClass;

class ShieldTest extends AbstractTestCase
{
    public function testVerify()
    {
        $shield = $this->getShield();
        $this->assertTrue($shield->verify('user1', 'password1'));
        $this->assertTrue($shield->verify('user2', 'password2'));
    }

    public function testVerifyWithUser()
    {
        $shield = $this->getShield();
        $this->assertTrue($shield->verify('user2', 'password2', 'jalallinux'));
    }

    public function testGetCurrentUser()
    {
        $shield = $this->getShield();

        $this->assertTrue($shield->verify('user1', 'password1'));
        $this->assertSame('default', $shield->getCurrentUser());

        $this->assertTrue($shield->verify('user2', 'password2'));
        $this->assertSame('jalallinux', $shield->getCurrentUser());
    }

    public function testUnauthorizedUser()
    {
        $shield = $this->getShield();
        $this->assertFalse($shield->verify('user3', 'password3'));
    }

    public function testUnauthorizedUserWithNullableCredentials()
    {
        $shield = $this->getShield();
        $this->assertFalse($shield->verify(null, null));
    }

    public function testUnauthorizedWithUser()
    {
        $shield = $this->getShield();
        $this->assertFalse($shield->verify('user1', 'password1', 'jalallinux'));
    }

    public function testGetUsers()
    {
        $rc = new ReflectionClass(Shield::class);
        $method = $rc->getMethod('getUsers');
        $method->setAccessible(true);

        $shield = new Shield([1, 2]);
        $return = $method->invokeArgs($shield, []);
        $this->assertSame(2, count($return));

        $shield = new Shield([1, 2]);
        $return = $method->invokeArgs($shield, [1]);
        $this->assertSame(1, count($return));
    }

    protected function getShield()
    {
        return new Shield($this->getUsers());
    }
}
