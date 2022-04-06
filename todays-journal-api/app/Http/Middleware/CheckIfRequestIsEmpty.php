<?php

namespace App\Http\Middleware;

use Closure;
use JsonException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use \App\Exceptions\RequestEmptyException;
use Illuminate\Contracts\Validation\Validator; 
use Illuminate\Validation\ValidationException;

class CheckIfRequestIsEmpty
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
        if($request->isMethod('POST') || $request->isMethod('PATCH')){
            if(!$request->all()){
                throw new RequestEmptyException;
            }
        }
        return $next($request);
    }
}
