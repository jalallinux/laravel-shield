<?php

namespace JalalLinuX\Shield\Tests;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use JalalLinuX\Shield\Shield;
use JalalLinuX\Shield\ShieldMiddleware;

class ShieldMiddlewareTest extends AbstractTestCase
{
    public function testMiddleware()
    {
        $request = $this->getRequest('user1', 'password1');
        $middleware = $this->getMiddleware();
        $return = $middleware->handle($request, function () {
            //
        });
        $this->assertNull($return);
    }

    public function testMiddlewareWithUser()
    {
        $request = $this->getRequest('user2', 'password2');
        $middleware = $this->getMiddleware();
        $return = $middleware->handle($request, function () {
            //
        }, 'jalallinux');
        $this->assertNull($return);
    }

    public function testInvalidShieldCredentialsException()
    {
        $this->expectException(UnauthorizedHttpException::class);

        $request = $this->getRequest('user3', 'password3');
        $middleware = $this->getMiddleware();
        $middleware->handle($request, function () {
            //
        });
    }

    public function testInvalidShieldCredentialsExceptionWithUser()
    {
        $this->expectException(UnauthorizedHttpException::class);

        $request = $this->getRequest('user1', 'password1');
        $middleware = $this->getMiddleware();
        $middleware->handle($request, function () {
            //
        }, 'jalallinux');
    }

    protected function getMiddleware()
    {
        return new ShieldMiddleware(new Shield($this->getUsers()));
    }

    protected function getRequest($user, $password)
    {
        return Request::create('http://localhost', 'GET', [], [], [], ['PHP_AUTH_USER' => $user, 'PHP_AUTH_PW' => $password]);
    }
}
