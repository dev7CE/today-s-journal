<?php

namespace Tests\Feature;

use App\Http\Middleware\CheckIfRequestIsEmpty;
use App\Http\Middleware\ValidateJsonApiDocument;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ValidateJsonApiDocumentTest extends TestCase
{
    /**
     * Setup the test environment.
     * THIS IS A JsonResponse OVERWRITTEN FUNCTION
     * of TestCase 'setUp' function.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutJsonApiDocumentFormatting();

        Route::any('test_route', function() {
            return 'OK';
        })->middleware(ValidateJsonApiDocument::class);
        
        Route::any('test_request_content', function() { return 'OK'; })
            ->middleware(CheckIfRequestIsEmpty::class);
    }
    
    /** @test */
    public function cannot_accept_empty_body_in_post_and_patch_request()
    {
        $this->withExceptionHandling();
        $error_structure ['errors'] = [[
            'title' => 'Request Content is Empty', 
            'statusCode' => '400', 
            'detail' => 'No content was found in received request', 
        ],];

        $this->post('test_request_content')
            ->assertStatus(400)
            ->assertExactJson($error_structure);

        $this->patch('test_request_content')
            ->assertStatus(400)
            ->assertExactJson($error_structure);
    }
    
    /** @test */
    public function only_accepts_valid_json_api_document()
    {
        $this->postJson('test_route',[
            'data' => [
                'type' => 'string', 
                'attributes' => [ 'attbte' => 'string' ]
            ]
        ])->assertSuccessful();

        $this->patchJson('test_route',[
            'data' => [
                'id' => '1', 
                'type' => 'string', 
                'attributes' => [ 'attbte' => 'string' ]
            ]
        ])->assertSuccessful();
    }
    
    /** @test */
    public function data_is_required()
    {
        $this->postJson('test_route',[])
            // ->dump();
            ->assertJsonApiValidationErrors('data');
        $this->patchJson('test_route',[])
            ->assertJsonApiValidationErrors('data');
    }
    
    /** @test */
    public function data_must_be_an_array()
    {
        $this->postJson('test_route',[
            'data' => 'string'
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data');
        
        $this->patchJson('test_route',[
            'data' => 'string'
        ])->assertJsonApiValidationErrors('data');
    }
    
    /** @test */
    public function data_type_is_required()
    {
        $this->postJson('test_route',[
            'data' => [
                'attributes' => [ 'attbte' => 'string' ]
            ]
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data.type');
        
        $this->patchJson('test_route',[
            'data' => [
                'id' => '1', 
                'attributes' => [ 'attbte' => 'string' ]
            ]
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data.type');
    }
    
    /** @test */
    public function data_type_must_be_a_string()
    {
        $this->postJson('test_route',[
            'data' => [
                'type' => 2, 
                'attributes' => [ 'attbte' => 'string' ]
            ]
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data.type');
        
        $this->patchJson('test_route',[
            'data' => [
                'type' => 2, 
                'id' => '1', 
                'attributes' => [ 'attbte' => 'string' ]
            ]
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data.type');
    }
    
    /** @test */
    public function data_attributes_is_required()
    {
        $this->postJson('test_route',[
            'data' => [
                'type' => 'string'
            ]
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data.attributes');
        
        $this->patchJson('test_route',[
            'data' => [
                'id' => '1', 
                'type' => 'string'
            ]
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data.attributes');
    }

    /** @test */
    public function data_attributes_must_be_an_array()
    {
        $this->postJson('test_route',[
            'data' => [
                'type' => 'string', 
                'attributes' => 'string'
            ]
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data.attributes');
        
        $this->patchJson('test_route',[
            'data' => [
                'id' => '1', 
                'type' => 'string', 
                'attributes' => 'string'
            ]
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data.attributes');
    }
    
    /** @test */
    public function data_id_is_required_in_patch_request()
    {   
        $this->patchJson('test_route',[
            'data' => [
                'type' => 'string', 
                'attributes' => [ 'attbte' => 'string' ]
            ]
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data.id');
    }
    
    /** @test */
    public function data_id_must_be_a_string_in_patch_request()
    {   
        $this->patchJson('test_route',[
            'data' => [
                'id' => 1, 
                'type' => 'string', 
                'attributes' => [ 'attbte' => 'string' ]
            ]
        ])
        //->dump()
        ->assertJsonApiValidationErrors('data.id');
    }
}
