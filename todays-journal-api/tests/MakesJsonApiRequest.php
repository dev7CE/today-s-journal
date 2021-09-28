<?php

namespace Tests;

use \Illuminate\Testing\TestResponse;

trait MakesJsonApiRequest
{

    /**
     * Call the given URI with a JSON request.
     * THIS IS A json OVERWRITTEN FUNCTION.
     * 
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function json($method, $uri, array $data = [], array $headers = []): TestResponse
    {
        $headers['accept'] = 'application/vnd.api+json';

        return parent::json($method, $uri, $data, $headers);
    }

    /**
     * Visit the given URI with a POST request, expecting a JSON response.
     * THIS IS A  postJson OVERWRITTEN FUNCTION.
     * 
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function postJson($uri, array $data = [], array $headers = []): TestResponse
    {
        $headers['content-type'] = 'application/vnd.api+json';

        return parent::postJson($uri, $data, $headers);
    }

    /**
     * Visit the given URI with a PATCH request, expecting a JSON response.
     * THIS IS A  patchJson OVERWRITTEN FUNCTION.
     * 
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function patchJson($uri, array $data = [], array $headers = []): TestResponse
    {
        $headers['content-type'] = 'application/vnd.api+json';

        return parent::patchJson($uri, $data, $headers);
    }
}