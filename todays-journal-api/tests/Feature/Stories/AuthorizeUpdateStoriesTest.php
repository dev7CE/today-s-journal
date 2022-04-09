<?php

namespace Tests\Feature\Stories;

use App\Story;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthorizeUpdateStoriesTest extends TestCase
{
    use RefreshDatabase;
    
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

        Sanctum::actingAs(factory(User::class)->create());
    }
    

    /** @test */
    public function only_users_can_update_stories()
    {
        $user = factory(User::class)->create();
        
        Sanctum::actingAs($user);

        /** @var Story */
        $story = factory(Story::class)->create();
        
        $response = $this->patchJson(route('api.v1.stories.update', $story), [
            'title' => 'The Story UPDATED',
            'url' => $story->url,
            'content' => 'Lorem Ipsum UPDATED'
        ]);
        
        $response->assertOk();
        $response->assertExactJson([
            'data' => [
                'type' => 'stories',
                'id' => (string) $story->getRouteKey(),
                'attributes' => [
                    'title' => 'The Story UPDATED',
                    'url' => $story->url,
                    'content' => 'Lorem Ipsum UPDATED'
                ],
                'links' => [
                    'self' => route('api.v1.stories.show', $story)
                ]
            ]
        ]);
        $response->assertHeader('Location', route('api.v1.stories.show', $story));
    }
}
