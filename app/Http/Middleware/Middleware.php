<?php
/**
 * Interfaz para middleware
 */

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;

interface Middleware
{
    /**
     * Procesa el middleware
     */
    public function handle(Request $request, callable $next): Response;
}

