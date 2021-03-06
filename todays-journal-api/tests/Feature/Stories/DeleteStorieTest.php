<?php

namespace Tests\Feature\Stories;

use App\Story;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteStorieTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     * OVERWRITTEN FUNCTION of TestCase 'setUp' function.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(factory(User::class)->create());
    }
    
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
