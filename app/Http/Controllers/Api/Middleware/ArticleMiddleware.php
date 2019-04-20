<?php
/**
 * Copyright © 2018 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Http\Controllers\Api\Middleware;

use Closure;
use \Illuminate\Http\Request;

/**
 * Class ArticleMiddleware
 * @package App\Http\Controllers\Api\Middleware
 */
class ArticleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->article->user_id != \Auth::user()->id) {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Not Found.',
            ], 404);
        }

        return $next($request);
    }
}
