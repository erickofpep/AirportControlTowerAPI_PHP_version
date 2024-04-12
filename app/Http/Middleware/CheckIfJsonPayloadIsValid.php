<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfJsonPayloadIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty($request->json()->all())) {
            return json_encode(['message'=>'The request is not a valid JSON.'], JSON_PRETTY_PRINT);
            /*
            return response()->json([
                'message' => 'The request is not a valid JSON.',
            ], 400);
            */
        }

        return $next($request);
    }

}
