<?php

namespace App\JsonAPI;

use Closure;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;

class JsonAPITestResponse { 

    /**
     * MACRO.
     * Assert error validation based on JSON:API Spec 
     * 
     * @return Closure
     */
    public function assertJsonApiValidationErrors (): Closure
    {
        // USING MACROS WILL ALLOW US to extend Laravel Default Classes.
        // In this case, TestResponse is extended with a new method for
        // assert JSON:API spec Validation Errors.
        // This Error Validation Test will be available globally
        // (for every single Test that we need) by calling:
        // $response->assertJsonApiValidationErrors('attribute_name');
        return function($attribute) {
            // Set $this as TestResponse instance:
            /** @var TestResponse $this */
            
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
