<?php

namespace App\Exceptions;

use Exception;

/**
 * Render Request Content Error in JSON format
 */
class RequestEmptyException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        $headers = [ 
            'content-type' => 'application/vnd.api+json' 
        ];

        $messageStructure = [
            'title' => 'Request Content is Empty', 
            'statusCode' => '400', 
            'detail' => 'No content was found in received request', 
        ];

        return response(
            $this->FormatExceptionMessage($messageStructure), 
            intval($messageStructure['statusCode']),
        )->withHeaders($headers);
    }

    /**
     * Format Message in JSON
     * @param array $messageStructure
     * 
     * @return array
     */
    protected function FormatExceptionMessage($messageStructure): array
    {
        $errors [] =  $messageStructure;
        return ['errors' => $errors];
    }
}
