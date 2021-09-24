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
    public function can_fetch_a_single_story()
    {
        // Show specific errors
        $this->withoutExceptionHandling();

        // $response = $this->get('/');
        // $response->assertStatus(200);
        // $story = Story::factory()->create();
        $story = factory(Story::class)->create();

        $response = $this->getJson(route('api.v1.stories.show', $story))
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
                    'self' => route('api.v1.stories.show', $story) 
                ]
            ]
        ]);

    }
    
    /** @test */
    public function can_fetch_all_stories()
    {
        // Show specific errors
        $this->withoutExceptionHandling();
        
        $stories = factory(Story::class, 1)->create();

        $response = $this->getJson(route('api.v1.stories.index'));

        $response->assertExactJson([
            'data' => [
                [
                    'type' => 'stories',
                    'id' => (string) $stories[0]->getRouteKey(),
                    'attributes' => [
                        'title' => $stories[0]->title,
                        'url' => $stories[0]->url,
                        'content' => $stories[0]->content
                    ],
                    'links' => [
                        'self' => route('api.v1.stories.show', $stories[0]) 
                    ]
                ],
                // [
                //     'type' => 'stories',
                //     'id' => (string) $stories[1]->getRouteKey(),
                //     'attributes' => [
                //         'title' => $stories[1]->title,
                //         'url' => $stories[1]->url,
                //         'content' => $stories[1]->content
                //     ],
                //     'links' => [
                //         'self' => route('api.v1.stories.show', $stories[1]) 
                //     ]
                // ]
            ],
            'links' => [
                'self' => route('api.v1.stories.index'),
            ]
        ]);
    }
}
