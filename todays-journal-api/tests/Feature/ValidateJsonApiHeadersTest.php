<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ValidateJsonApiHeadersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function accept_header_must_be_present_in_all_request()
    {
        Route::get('test_route', function() {
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->getJson('test_route')->assertStatus(406);
        // With APP_DEBUG=false
        // ->dump();
        // 406: HTTP_NOT_ACCEPTABLE

        $this->get('test_route',[
            'accept' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }

    /** @test */
    public function content_type_header_must_be_present_in_all_post_request()
    {
        Route::post('test_route', function() {
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->post('test_route',[],[
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415);
        // 415: HTTP_UNSUPPORTED_MEDIA_TYPE
        // content-Type: application/vnd.api+json

        $this->post('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }
    
    /** @test */
    public function content_type_header_must_be_present_in_all_patch_request()
    {
        Route::patch('test_route', function() {
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->patch('test_route',[],[
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415);
        // 415: HTTP_UNSUPPORTED_MEDIA_TYPE
        // content-Type: application/vnd.api+json

        $this->patch('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }

    /** @test */
    public function content_type_header_must_be_present_in_responses()
    {
        Route::any('test_route', function() {
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->get('test_route',[
            'accept' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json');
        
        $this->post('test_route',[],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json');
        
        $this->patch('test_route',[],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json');
    }

    /** @test */
    public function content_type_header_must_not_be_present_in_empty_responses()
    {
        Route::any('empty_response', function() {
            return response()->noContent();
        })->middleware(ValidateJsonApiHeaders::class);

        $this->get('empty_response', [
            'accept' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');
        
        $this->post('empty_response', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');
        
        $this->patch('empty_response', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->delete('empty_response', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');
    }
}
