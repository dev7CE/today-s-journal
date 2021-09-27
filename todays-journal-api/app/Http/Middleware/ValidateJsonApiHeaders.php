<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidateJsonApiHeaders
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
        if($request->header('accept') !== 'application/vnd.api+json')
        {
            // AVOID NULL Messages by sending a text as second 
            // parameter: 
            throw new HttpException(406, __('Not Acceptable'));
            // throw new HttpException(406);
        }

        if($request->isMethod('POST') || $request->isMethod('PATCH'))
        {
            if($request->header('content-type') !== 'application/vnd.api+json')
            {
                throw new HttpException(415, __('Unsupported Media Type'));
            }   
        }

        return $next($request)->withHeaders([
            'content-type' => 'application/vnd.api+json'
        ]);
    }
}
