<?php
/**
 * Clase base para middleware
 */

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;

abstract class BaseMiddleware implements Middleware
{
    /**
     * Procesa el middleware
     */
    abstract public function handle(Request $request, callable $next): Response;
}

