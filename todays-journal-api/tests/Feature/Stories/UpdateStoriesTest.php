<?php

namespace Tests\Feature\Stories;

use App\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateStoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_update_story()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();
        
        /** @var Story */
        $story = factory(Story::class)->create();

        $response = $this->patchJson(route('api.v1.stories.update', $story), [
            'title' => 'The Story UPDT',
            'url' => 'the-story-updt',
            'content' => 'Lorem Ipsum UPDT'
        ]);
        // Show JSON output
        //->dump();
        
        $response->assertOk();
        $response->assertExactJson([
            'data' => [
                'type' => 'stories',
                'id' => (string) $story->getRouteKey(),
                'attributes' => [
                    'title' => 'The Story UPDT',
                    'url' => 'the-story-updt',
                    'content' => 'Lorem Ipsum UPDT'
                ],
                'links' => [
                    'self' => route('api.v1.stories.show', $story)
                ]
            ]
        ]);
        $response->assertHeader('Location', route('api.v1.stories.show', $story));
    }

    //------------------ TITLE VALIDATIONS
    /** @test */
    public function title_is_required()
    {
        /** @var Story */
        $story = factory(Story::class)->create();

        $response = $this->patchJson(route('api.v1.stories.update', $story), [
            'url' => 'the-story-updt',
            'content' => 'Lorem Ipsum UPDT'
        ]);

        $response->assertJsonApiValidationErrors('title');
    }

    /** @test */
    public function title_must_be_at_leats_4_characters()
    {
        /** @var Story */
        $story = factory(Story::class)->create();

        $response = $this->patchJson(route('api.v1.stories.update', $story), [
            'title' => 'Tsu',
            'url' => 'the-story-updt',
            'content' => 'Lorem Ipsum UPDT'
        ]);

        $response->assertJsonApiValidationErrors('title');
    }

    //-------------------- URL VALIDATIONS
    /** @test */
    public function url_is_required()
    {
        /** @var Story */
        $story = factory(Story::class)->create();

        $response = $this->patchJson(route('api.v1.stories.update', $story), [
            'title' => 'The Story UPDT',
            'content' => 'Lorem Ipsum UPDT'
        ]);

        $response->assertJsonApiValidationErrors('url');
    }

    //---------------- CONTENT VALIDATIONS
    /** @test */
    public function content_is_required()
    {
        /** @var Story */
        $story = factory(Story::class)->create();

        $response = $this->patchJson(route('api.v1.stories.update', $story), [
            'title' => 'The Story UPDT',
            'url' => 'storie-1'
        ]);

        $response->assertJsonApiValidationErrors('content');
    }
}
