<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class JsonApiValidationErrorResponse extends JsonResponse
{
    /**
     * Extended Constructor
     * 
     * @param ValidationException $exception
     * @param int $status default status is 422
     * @return void
     */
    public function __construct(ValidationException $exception, $status = 422) {
        // Display error validation messages
        // dd($exception->errors());
        
        $headers = [ 
            'content-type' => 'application/vnd.api+json' 
        ];

        // Make throw Expectation Failed Exception in 
        // JSON:API error response:
        // return response()->json([ 'error' => $errors ], 422);
        
        $data = $this->formatJsonApiErrors($exception);
        
        parent::__construct($data, $status, $headers);
    }

    /**
     * Generate JSON:API spec Error Validation Structure
     * @param ValidationException $exception the validations failed 
     * @return array the structures as array
     */
    protected function formatJsonApiErrors(ValidationException $exception)
    : array
    {
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
        return [ 'errors' => $errors ];
    }
}
