<?php

namespace Tests\Feature\Stories;

use App\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SortStoriesTest extends TestCase
{
    /** @test */
    public function can_sort_stories_by_title()
    {
        factory(Story::class)->create(['title' => 'C Story']);
        factory(Story::class)->create(['title' => 'A Story']);
        factory(Story::class)->create(['title' => 'B Story']);

        $url = route('api.v1.stories.index',['sort' => 'title']);


        $this->getJson($url)->assertSeeInOrder([
            'A Story',
            'B Story',
            'C Story'
        ]);
    }

    /** @test */
    public function can_sort_stories_by_title_descending()
    {
        factory(Story::class)->create(['title' => 'B Story']);
        factory(Story::class)->create(['title' => 'C Story']);
        factory(Story::class)->create(['title' => 'A Story']);

        $url = route('api.v1.stories.index',['sort' => '-title']);
        
        $this->getJson($url)->assertSeeInOrder([
            'C Story',
            'B Story',
            'A Story'
        ]);
    }

    /** @test */
    public function can_sort_stories_by_content()
    {
        factory(Story::class)->create(['content' => 'C Lorem Ipsum']);
        factory(Story::class)->create(['content' => 'A Lorem Ipsum']);
        factory(Story::class)->create(['content' => 'B Lorem Ipsum']);

        $url = route('api.v1.stories.index',['sort' => 'content']);


        $this->getJson($url)->assertSeeInOrder([
            'A Lorem Ipsum',
            'B Lorem Ipsum',
            'C Lorem Ipsum'
        ]);
    }

    /** @test */
    public function can_sort_stories_by_content_descending()
    {
        factory(Story::class)->create(['content' => 'B Lorem Ipsum']);
        factory(Story::class)->create(['content' => 'C Lorem Ipsum']);
        factory(Story::class)->create(['content' => 'A Lorem Ipsum']);

        $url = route('api.v1.stories.index',['sort' => '-content']);
        
        $this->getJson($url)->assertSeeInOrder([
            'C Lorem Ipsum',
            'B Lorem Ipsum',
            'A Lorem Ipsum'
        ]);
    }
}
