<?php

namespace JalalLinuX\Shield;

use Closure;
use Illuminate\Http\Request;

class ShieldMiddleware
{
    public function __construct(protected Shield $shield)
    {
    }

    /**
     * @param  Request  $request
     */
    public function handle($request, Closure $next, ?string $user = null): mixed
    {
        if ($this->shield->verify($request->getUser(), $request->getPassword(), $user) === false) {
            throw new \Illuminate\Auth\Access\AuthorizationException;
        }

        return $next($request);
    }
}
