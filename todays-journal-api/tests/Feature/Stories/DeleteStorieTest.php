<?php

namespace Tests\Feature\Stories;

use App\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteStorieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_delete_stories()
    {
        $story = factory(Story::class)->create();

        $this->deleteJson(route('api.v1.stories.destroy', $story))
            ->assertNoContent();

        // Additional Assert
        $this->assertDatabaseCount('stories', 0);
    }
}
