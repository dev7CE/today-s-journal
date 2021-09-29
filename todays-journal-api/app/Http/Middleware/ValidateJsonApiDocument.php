<?php

namespace App\Http\Middleware;

use Closure;

class ValidateJsonApiDocument
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
        $validationFields = [
            'data' => ['required', 'array'],
            'data.type' => ['required', 'string'],
            'data.attributes' => ['required', 'array']
        ];

        if($request->isMethod('POST') || $request->isMethod('PATCH'))
        {
            if($request->isMethod('PATCH'))
            {
                $validationFields['data.id'] = [
                    'required', 'string'
                ];
            }
            $request->validate($validationFields);
        }
        return $next($request);
    }
}
