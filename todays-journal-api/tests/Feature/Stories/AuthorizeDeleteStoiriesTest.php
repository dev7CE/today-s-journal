<?php

namespace Tests\Feature\Stories;

use App\Story;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthorizeDeleteStoiriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_users_can_delete_stories()
    {
        $story = factory(Story::class)->create();

        Sanctum::actingAs(factory(User::class)->create());

        $this->deleteJson(route('api.v1.stories.destroy', $story))
            ->assertNoContent();

        // Additional Assert
        $this->assertDatabaseCount('stories', 0);
    }
}
