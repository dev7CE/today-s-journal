<?php

namespace Tests\Feature\Stories;

use App\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListStoriesTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_fetch_a_single_article()
    {
        // Show specific errors
        $this->withoutExceptionHandling();

        // $response = $this->get('/');
        // $response->assertStatus(200);
        // $story = Story::factory()->create();
        $story = factory(Story::class)->create();

        $response = $this->getJson('api/v1/stories/'.$story->getRouteKey())
            ->dump();

        // Basic Test
        // $response->assertSee($story->title);
        // JSON:API specification
        $response->assertExactJson([
            'data' => [
                'type' => 'stories',
                'id' => (string) $story->getRouteKey(),
                'attributes' => [
                    'title' => $story->title,
                    'url' => $story->url,
                    'content' => $story->content
                ],
                'links' => [
                    'self' => url('/api/v1/stories/'.$story->getRouteKey()) 
                ]
            ]
        ]);

    }
}
