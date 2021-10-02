<?php

namespace Tests\Feature\Stories;

use App\Story;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateStoryTest extends TestCase
{
    
    use RefreshDatabase;
    // If we dont want to load all test:
    //use MakesJsonApiRequest;

    /** @test */
    public function can_create_a_single_story()
    {
        // Show specific errors
        // (To get the JSON:API Error Response, comment 
        // the line below:)
        //$this->withoutExceptionHandling();
        // To avoid foreign contraint errors, 
        // we can disable FOREIGN CONSTRAINTS on migrations
        // in order to sent no user_id data field.

        // This story is create but not stored in DB
        $story = factory(Story::class)->make([
            // In case we need to add User relationship
            // manually, we can send this array 
            // association:
            // 'user_id' => $user->getRouteKey()
        ]);

        $response = $this->postJson(route('api.v1.stories.store'), [
            'title' => $story->title,
            'url' => $story->url,
            'content' => $story->content
        ]);
        // Show JSON output
        //->dump();
        
        $storyAdded = Story::first();
        
        $response->assertCreated();
        $response->assertExactJson([
            'data' => [
                'type' => 'stories',
                'id' => (string) $storyAdded->getRouteKey(),
                'attributes' => [
                    'title' => $story->title,
                    'url' => $story->url,
                    'content' => $story->content
                ],
                'links' => [
                    'self' => route('api.v1.stories.show', $storyAdded)
                ]
            ]
        ]);
        $response->assertHeader('Location', route('api.v1.stories.show', $storyAdded));
        // GET Response Headerds
        // $response->dumpHeaders();
            
    }

    //------------------ TITLE VALIDATIONS
    /** @test */
    public function title_is_required()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.stories.store'), [
            'url' => 'storie-1',
            'content' => 'Lorem Ipsum'
        ]);
        // Show JSON output
        //->dump();

        // Basic Error Validation Testing (without JSON:API spec)
        //$response->assertJsonValidationErrors('data.attributes.title');

        $response->assertJsonApiValidationErrors('title');
    }
    
    /** 
     * @test 
     * The goal is return an Expectation Failed Exception
     */
    // This 'TEST' was commented in order to success 
    // all the rest of tests.
    // public function title_is_required_with_no_error()
    // {
    //     $response = $this->postJson(route('api.v1.stories.store'), [
    //         'title' => 'storie 1',
    //         'url' => 'storie-1',
    //         'content' => 'Lorem Ipsum'
    //     ]);
    //
    //     $response->assertJsonApiValidationErrors('title');
    // }

    /** @test */
    public function title_must_be_at_leats_4_characters()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.stories.store'), [
            'title' => 'sto',
            'url' => 'storie-1',
            'content' => 'Lorem Ipsum'
        ]);
        // Show JSON output
        //->dump();

        // Basic Error Validation Testing (without JSON:API spec)
        //$response->assertJsonValidationErrors('data.attributes.title');

        $response->assertJsonApiValidationErrors('title');
    }

    //-------------------- URL VALIDATIONS
    /** @test */
    public function url_is_required()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.stories.store'), [
            'title' => 'storie 1',
            'content' => 'Lorem Ipsum'
        ]);
        // Show JSON output
        //->dump();

        // Basic Error Validation Testing (without JSON:API spec)
        //$response->assertJsonValidationErrors('data.attributes.url');

        $response->assertJsonApiValidationErrors('url');
    }

    //---------------- CONTENT VALIDATIONS
    /** @test */
    public function content_is_required()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.stories.store'), [
            'title' => 'storie 1',
            'url' => 'storie-1'
        ]);
        // Show JSON output
        //->dump();

        // Basic Error Validation Testing (without JSON:API spec)
        // $response->assertJsonValidationErrors('data.attributes.content');

        $response->assertJsonApiValidationErrors('content');
    }
}
