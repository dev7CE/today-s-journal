<?php

namespace Tests\Feature\Stories;

use App\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginateStoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_paginated_stories()
    {
        $stories = factory(Story::class)
            ->times(10)
            ->create();
        
        $url = route('api.v1.stories.index', [
            'page[size]' => 2,
            'page[number]' => 3
        ]);

        // dump(urldecode($url));
        $response = $this->getJson($url);
        $response->assertJsonCount(2, 'data')
            ->assertDontSee($stories[0]->title)
            ->assertDontSee($stories[1]->title)
            ->assertDontSee($stories[2]->title)
            ->assertDontSee($stories[3]->title)
            ->assertSee($stories[4]->title)
            ->assertSee($stories[5]->title)
            ->assertDontSee($stories[6]->title)
            ->assertDontSee($stories[7]->title)
            ->assertDontSee($stories[8]->title)
            ->assertDontSee($stories[9]->title)
        ;

        // dump($response->json('links'));
        // foreach ($response->json('links') as $link ) {
        //     dump(urldecode($link));
        // }

        $response->assertJsonStructure([
            'links' => ['first','last', 'prev', 'next']
        ]);

        $response->assertJsonFragment([
            'first' => route('api.v1.stories.index', ['page[size]' => 2, 'page[number]' => 1]),
            'last' => route('api.v1.stories.index', ['page[size]' => 2, 'page[number]' => 5]),
            'prev' => route('api.v1.stories.index', ['page[size]' => 2, 'page[number]' => 2]),
            'next' => route('api.v1.stories.index', ['page[size]' => 2, 'page[number]' => 4]),
        ]);
    }
}
