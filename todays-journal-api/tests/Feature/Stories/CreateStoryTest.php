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
}
