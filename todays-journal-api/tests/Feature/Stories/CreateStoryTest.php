<?php

namespace Tests\Feature\Stories;

use App\Story;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateStoryTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function can_create_a_single_story()
    {
        // Show specific errors
        $this->withoutExceptionHandling();
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
            'data' => [
                'type' => 'stories',
                'attributes' => [
                    'title' => $story->title,
                    'url' => $story->url,
                    'content' => $story->content
                ]
            ]
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
            'data' => [
                'type' => 'stories',
                'attributes' => [
                    'url' => 'storie-1',
                    'content' => 'Lorem Ipsum'
                ]
            ]
        ]);
        // Show JSON output
        //->dump();

        // Basic Error Validation Testing (without JSON:API spec)
        $response->assertJsonValidationErrors('data.attributes.title');
    }
    
    /** @test */
    public function title_must_be_at_leats_4_characters()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.stories.store'), [
            'data' => [
                'type' => 'stories',
                'attributes' => [
                    'title' => 'sto',
                    //'url' => 'storie-1',
                    'content' => 'Lorem Ipsum'
                ]
            ]
        ]);
        // Show JSON output
        //->dump();

        // Basic Error Validation Testing (without JSON:API spec)
        $response->assertJsonValidationErrors('data.attributes.title');
    }

    //-------------------- URL VALIDATIONS
    /** @test */
    public function url_is_required()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.stories.store'), [
            'data' => [
                'type' => 'stories',
                'attributes' => [
                    'title' => 'storie 1',
                    'content' => 'Lorem Ipsum'
                ]
            ]
        ]);
        // Show JSON output
        //->dump();

        // Basic Error Validation Testing (without JSON:API spec)
        $response->assertJsonValidationErrors('data.attributes.url');
    }

    //---------------- CONTENT VALIDATIONS
    /** @test */
    public function content_is_required()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.stories.store'), [
            'data' => [
                'type' => 'stories',
                'attributes' => [
                    'title' => 'storie 1',
                    'url' => 'storie-1'
                ]
            ]
        ]);
        // Show JSON output
        //->dump();

        // Basic Error Validation Testing (without JSON:API spec)
        $response->assertJsonValidationErrors('data.attributes.content');
    }
}
