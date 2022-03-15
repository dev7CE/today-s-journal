<?php

namespace Tests\Feature\Stories;

use App\Story;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthorizeStoreStoriesTest extends TestCase
{
    // IMPORTANT: Authentication added to 
    // 'CreateStoryTest' test
    use RefreshDatabase;

    /** @test */
    public function authenticaded_users_can_create_stories()
    {
        
        $user = factory(User::class)->create();
        /** @var Story $story */
        $story = factory(Story::class)->make([
            'user_id' => null
        ]);

        $this->assertDatabaseMissing('stories', $story->toArray());
        // Default Authentication
        // $this->actingAs($user);
        // Using Sanctum Authentication
        Sanctum::actingAs($user);
        
        $response = $this->postJson(route('api.v1.stories.store'), [
            'title' => $story->title,
            'url' => $story->url,
            'content' => $story->content
        ]);

        /** @var Story $storyAdded */
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

        $this->assertDatabaseHas('stories', [
            'user_id' => $user->id,
            'title' => $story->title,
            'url' => $story->url,
            'content' => $story->content
        ]);

        $response->assertHeader('Location', 
            route('api.v1.stories.show', $storyAdded)
        );

    }

    /** @test */
    public function guest_users_cannot_create_stories()
    {
        /** @var Story $story */
        $story = factory(Story::class)->make([
            'user_id' => null
        ]);
        
        $this->assertDatabaseMissing('stories', $story->toArray());
        
        $response = $this->postJson(route('api.v1.stories.store'), [
            'title' => $story->title,
            'url' => $story->url,
            'content' => $story->content
        ]);
        
        $response->assertUnauthorized();
    }
}
