<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('Accept', 'application/json');
        
        $response = $next($request);
        
        // Ensure the response is JSON
        if (!$response instanceof \Illuminate\Http\JsonResponse) {
            $response = response()->json(
                $response->content(),
                $response->status(),
                $response->headers->all()
            );
        }
        
        return $response->header('Content-Type', 'application/json');
    }
}
