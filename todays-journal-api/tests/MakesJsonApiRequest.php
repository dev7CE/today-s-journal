<?php

namespace Tests;

use Closure;
use \Illuminate\Support\Str;
use \Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;

trait MakesJsonApiRequest
{
    // Current php version is 7.3 so we cannot
    // define typed properties (php 7.4 minimun)
    /** @var bool $formatJsonApiDocument */
    protected $formatJsonApiDocument = true;
    
    /**
     * Disable JSON:API spec document format to custom it.
     * 
     * @internal This will be useful when testing JSON:API Document
     * 
     * @return void
     */
    public function withoutJsonApiDocumentFormatting(): void
    {
        $this->formatJsonApiDocument = false;
    }
    
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
     * @param  array  $data the attributes ONLY
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function json($method, $uri, array $data = [], array $headers = []): TestResponse
    {
        $headers['accept'] = 'application/vnd.api+json';

        // Display $data sended
        // dd($data);
        // type will be obtained by $uri param
        // dd($uri);

        if($this->formatJsonApiDocument)
        {
            // Get URL Components and their respect values
            // ['component_name'] Get specific URL component, e.g. 'path'
            // dump(parse_url($uri)['component_name']);
            $path = parse_url($uri)['path'];

            $formattedData ['data']['attributes'] = $data;
            $formattedData ['data']['type'] = $type = (string)Str::of($path)->after('api/v1/')->before('/');
            $formattedData ['data']['id'] = $id = (string)Str::of($path)->after($type)->replace('/','');
            //dd($formattedData);
            // Get this values in both PATCH and POST request
            // to validate we receive the appropiate for each
            // request
            // dd($path);
            // dd($id);
            // Delete empty key values. This will work if
            // the request is POST, 'data'.'id' will be
            // deleted:
            // (WARNING: will also delete 'data')
            // dd(array_filter($formattedData['data']));
            // This should be the rigth output
            // dump(['data' => array_filter($formattedData['data'])]);
            $formattedData = ['data' => array_filter($formattedData['data'])];
        }

        return parent::json($method, $uri, $formattedData ?? $data, $headers);
    }

    /**
     * Visit the given URI with a POST request, expecting a JSON response.
     * THIS IS A  postJson OVERWRITTEN FUNCTION.
     * 
     * @param  string  $uri
     * @param  array  $data the attributes ONLY
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
     * @param  array  $data the attributes ONLY
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
            
            $pointer = Str::of($attribute)->startsWith('data') 
                ? '/'.str_replace('.', '/', $attribute) 
                : '/data/attributes/'.$attribute;
            
            try {
                $this->assertJsonFragment([
                    'source' => [
                        'pointer' => $pointer
                    ]
                ]);
                // Get the Exception Class
                //} catch (\Exception $e) {
                // dd($e);
            // Custom ExpectationFailedException message
            } catch (ExpectationFailedException $e) {
                PHPUnit::fail(
                    'Failed to find a JSON:API validation error for key: '
                    .$attribute.PHP_EOL.PHP_EOL.$e->getMessage()
                );
            }

            try {
                $this->assertJsonStructure([
                    'errors' => [
                        ['title', 'detail', 'source' => ['pointer']]
                    ]
                ]);
            } catch (ExpectationFailedException $e) {
                PHPUnit::fail(
                    'Failed to find a valid JSON:API error response '
                    .PHP_EOL.PHP_EOL.$e->getMessage()
                );
            }
            
            $this->assertStatus(422);
            //Code 422 = HTTP_UNPROCESSABLE_ENTITY
            $this->assertHeader('content-type', 'application/vnd.api+json');

            // This latest two Asserts are not requiered to be customized 
            // their message Exception, they're well descriptive.
        };
    }
}
