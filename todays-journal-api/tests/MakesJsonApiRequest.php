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
            $formattedData = $this->getFormattedData($uri, $data);
            //dd($formattedData);
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
     * Get array of JSON:API spec document structure
     * @param string $uri the request URI
     * @param array $data the Resource Atributes
     * @return array JSON:API structure
     */
    protected function getFormattedData ($uri, array $data):array
    {
        // Get URL Components and their respect values
        // ['component_name'] Get specific URL component, e.g. 'path'
        // dump(parse_url($uri)['component_name']);
        $path = parse_url($uri)['path'];
        $type = (string)Str::of($path)->after('api/v1/')->before('/');
        $id = (string)Str::of($path)->after($type)->replace('/', '');

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
    
        return [
            'data' => array_filter([
                'type' => $type,
                'id' => $id,
                'attributes' => $data
            ])
        ];
    }
}
