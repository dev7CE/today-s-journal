<?php

namespace Tests;

use Closure;
use \Illuminate\Testing\TestResponse;

trait MakesJsonApiRequest
{
    /**
     * Setup the test environment.
     * THIS IS A OVERWRITTEN FUNCTION of
     * \Test\TestCase 'setUp' function.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // USING MACROS WILL ALLOW US to extend Laravel Default Classes.
        // In this case, TestResponse is extended with a new method for
        // assert JSON:API spec Validation Errors.
        // This Error Validation Test will be available globally
        // (for every single Test that we need) by calling:
        // $response->assertJsonApiValidationErrors('attribute_name');
        TestResponse::macro(
            'assertJsonApiValidationErrors', 
            $this->assertJsonApiValidationErrors()
        );
        
    }

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

    /**
     * Validate JSON:API spec error validation
     * @return Closure
     */
    protected function assertJsonApiValidationErrors(): Closure
    {
        return function($attribute) {
            // Set $this as TestResponse instance:
            /** @var \Illuminate\Testing\TestResponse $this */
            $this->assertJsonStructure([
                'errors' => [
                    ['title', 'detail', 'source' => ['pointer']]
                ]
            ])->assertJsonFragment([
                'source' => [
                    'pointer' => '/data/attributes/'.$attribute
                ]
            ])->assertStatus(422)
            //Code 422 = HTTP_UNPROCESSABLE_ENTITY
            ->assertHeader('content-type', 'application/vnd.api+json');
        };
    }
}
