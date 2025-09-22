<?php

namespace App\Http\Middleware;

use Illuminate\View\Factory;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class HandleAppearance
{
    public function __construct(private readonly Factory $factory)
    {
    }
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request):Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->factory->share('appearance', $request->cookie('appearance') ?? 'system');

        return $next($request);
    }
}
