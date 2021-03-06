<?php

namespace Khludev\KuLaraPanel\Middleware;

use Illuminate\Auth\Access\AuthorizationException;

class RestrictDemo
{
    public function handle($request, $next)
    {
        if (config('kulara.demo.enabled') && (!$this->methodAllowed() && !$this->routeAllowed())) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Feature disabled in demo mode.',
                ], 422);
            }
            else {
                throw new AuthorizationException();
            }
        }

        return $next($request);
    }

    public function methodAllowed()
    {
        $request_method = strtolower(request()->method());
        $whitelisted_methods = array_map('strtolower', config('kulara.demo.whitelist.methods'));

        return in_array($request_method, $whitelisted_methods);
    }

    public function routeAllowed()
    {
        foreach (config('kulara.demo.whitelist.routes') as $route) {
            if (request()->is($route)) {
                return true;
            }
        }

        return false;
    }
}
