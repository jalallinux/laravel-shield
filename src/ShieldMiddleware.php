<?php

namespace JalalLinuX\Shield;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ShieldMiddleware
{
    public function __construct(protected Shield $shield) {
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @param string|null $user
     * @return mixed
     */
    public function handle($request, Closure $next, ?string $user = null): mixed
    {
        if ($this->shield->verify($request->getUser(), $request->getPassword(), $user) === false) {
            throw new UnauthorizedHttpException('Basic');
        }

        return $next($request);
    }
}
