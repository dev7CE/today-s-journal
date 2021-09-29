<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Convert a validation exception into a JSON response.
     * THIS IS A \Illuminate\Foundation\Exceptions\Handler 
     * OVERWRITTEN FUNCTION.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {   
        // Display error validation messages
        // dd($exception->errors());
        // Display de exception main title
        // dd($exception->getMessage());
        $title = $exception->getMessage();
        
        $errors = [];
        foreach ($exception->errors() as $field => $message) {
            $pointer = "/".str_replace('.', '/', $field);

            $errors [] = [
                'title' => $title,
                'detail' => $message[0],
                'source' => [
                    'pointer' => $pointer
                ]
            ];
        }

        return response()->json([ 'errors' => $errors ], 422);
        // Make throw Expectation Failed Exception in 
        // JSON:API error response:
        //return response()->json([ 'error' => $errors ], 422);
    }
}
