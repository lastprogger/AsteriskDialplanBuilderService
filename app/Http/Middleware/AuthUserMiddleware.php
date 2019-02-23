<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\UnauthorizedException;
use InternalApi\PbxSchemeServiceApi\Facade\UserServiceApiFacade;
use InternalApi\UserServiceApi\UserServiceApi;

class AuthUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader === null) {
            throw new UnauthorizedException('Unauthorized', 401);
        }

        try {
            $user = UserServiceApiFacade::user()->getAuthUser($authorizationHeader);
            UserServiceApi::setCurrentUser($user);

        } catch (\Exception $e) {
            throw new UnauthorizedException('Unauthorized', 401);
        }

        return $next($request);
    }
}
