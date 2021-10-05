<?php

namespace Tests\Feature\Stories;

use App\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SortStoriesTest extends TestCase
{
    use RefreshDatabase;

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

    // ---------------------------------- BY MULTIPLE PARAMS
    /** @test */
    public function can_sort_stories_by_title_and__dash_content()
    {
        factory(Story::class)->create([
            'title' => 'A Title',
            'content' => 'A Lorem Ipsum'
        ]);

        factory(Story::class)->create([
            'title' => 'B Title',
            'content' => 'B Lorem Ipsum'
        ]);
        factory(Story::class)->create([
            'title' => 'A Title',
            'content' => 'C Lorem Ipsum'
        ]);

        $url = route('api.v1.stories.index', ['sort' => 'title,-content']);

        $this->getJson($url)->assertSeeInOrder([
            'C Lorem Ipsum',
            'A Lorem Ipsum',
            'B Lorem Ipsum'
        ]);
    }

    /** @test */
    public function cannot_sort_stories_by_unknown_fields()
    {
        factory(Story::class, 3)->create();

        $url = route('api.v1.stories.index', ['sort' => 'unknown']);

        $this->getJson($url)->assertStatus(400);
        // 400 code: HTTP_BAD_REQUEST
    }
}
