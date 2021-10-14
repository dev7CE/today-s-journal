<?php

namespace Tests\Feature\Stories;

use App\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterStoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_filter_stories_by_title()
    {
        factory(Story::class)->create([
            'title' => 'About Artisan New Commands',
        ]);

        factory(Story::class)->create([
            'title' => 'New Laravel Version Was Arrived',
        ]);

        // Filtering according to JSON:API spec
        // resource?filter[attribute]=keyword

        $url = route('api.v1.stories.index',[
            'filter' => [
                'title' => 'Artisan',
            ]
        ]);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('About Artisan New Commands')
            ->assertDontSee('New Laravel Version Was Arrived');
    }

    /** @test */
    public function can_filter_stories_by_content()
    {
        factory(Story::class)->create([
            'content' => 'These are the Artisan new commands',
        ]);

        factory(Story::class)->create([
            'content' => 'Artisan has some bugs since new version',
        ]);

        factory(Story::class)->create([
            'content' => 'New features of this Laravel Version are',
        ]);

        $url = route('api.v1.stories.index',[
            'filter' => [
                'content' => 'Artisan',
            ]
        ]);

        $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertSee('These are the Artisan new commands')
            ->assertSee('Artisan has some bugs since new version')
            ->assertDontSee('New features of this Laravel Version are');
    }

    /** @test */
    public function can_filter_stories_by_year()
    {
        factory(Story::class)->create([
            'title' => 'About Artisan New Commands - 2021',
            'created_at' => now()->year(2021),
        ]);

        factory(Story::class)->create([
            'title' => 'About Artisan New Commands - Beta 2020',
            'created_at' => now()->year(2020),
        ]);

        $url = route('api.v1.stories.index',[
            'filter' => [
                'year' => '2021',
            ]
        ]);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('About Artisan New Commands - 2021')
            ->assertDontSee('About Artisan New Commands - Beta 2020');
    }

    /** @test */
    public function can_filter_stories_by_month()
    {
        factory(Story::class)->create([
            'title' => 'About Artisan New Commands - March',
            'created_at' => now()->month(3),
        ]);

        factory(Story::class)->create([
            'title' => 'Top Features of C# 7 - March',
            'created_at' => now()->month(3),
        ]);

        factory(Story::class)->create([
            'title' => 'Another New in January Month',
            'created_at' => now()->month(1),
        ]);

        $url = route('api.v1.stories.index',[
            'filter' => [
                'month' => '3',
            ]
        ]);

        $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertSee('About Artisan New Commands - March')
            ->assertSee('Top Features of C# 7 - March')
            ->assertDontSee('Another New in January Month');
    }

    /** @test */
    public function cannot_filter_stories_by_unknown_filters()
    {
        factory(Story::class, 2)->create();

        $url = route('api.v1.stories.index',[
            'filter' => [
                'notvalid' => 'filter',
            ]
        ]);

        // Assert BAD_REQUEST (400)
        $this->getJson($url)->assertStatus(400);
    }
}
