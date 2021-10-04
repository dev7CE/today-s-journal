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
            'url' => $story->url,
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
                    'url' => $story->url,
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

    /** @test */
    public function url_must_be_unique()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        /** @var Story */
        $story1 = factory(Story::class)->create();
        
        /** @var Story */
        $story2 = factory(Story::class)->create();

        $response = $this->patchJson(route('api.v1.stories.update', $story1), [
            'title' => 'The Story UPDT',
            'url' => $story2->url,
            'content' => 'Lorem Ipsum'
        ]);
        // Show JSON output
        //->dump();

        $response->assertJsonApiValidationErrors('url');
    }
    
    /** @test */
    public function url_must_only_contain_letters_numbers_and_dashes()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        /** @var Story */
        $story = factory(Story::class)->create();

        $response = $this->patchJson(route('api.v1.stories.update', $story), [
            'title' => 'The Story UPDT',
            'url' => '$%^&',
            'content' => 'Lorem Ipsum'
        ]);
        // Show JSON output
        //->dump();

        $response->assertJsonApiValidationErrors('url');
    }

    /** @test */
    public function url_must_not_contain_underscores()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        /** @var Story */
        $story = factory(Story::class)->create();

        $response = $this->patchJson(route('api.v1.stories.update', $story), [
            'title' => 'The Story UPDT',
            'url' => 'thestory_upt_with_underscores',
            'content' => 'Lorem Ipsum'
        ]);
        // Show JSON output
        //->dump();

        $response->assertJsonApiValidationErrors('url');
    }

    /** @test */
    public function url_must_not_start_with_dashes()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        /** @var Story */
        $story = factory(Story::class)->create();

        $response = $this->patchJson(route('api.v1.stories.update', $story), [
            'title' => 'The Story UPDT',
            'url' => '-the-story-starting-with-a-dash',
            'content' => 'Lorem Ipsum'
        ]);
        // Show JSON output
        //->dump();

        $response->assertJsonApiValidationErrors('url');
    }

    /** @test */
    public function url_must_not_end_with_dashes()
    {
        // Show specific errors
        // $this->withoutExceptionHandling();

        /** @var Story */
        $story = factory(Story::class)->create();

        $response = $this->patchJson(route('api.v1.stories.update', $story), [
            'title' => 'The Story UPDT',
            'url' => 'the-story-ending-with-a-dash-',
            'content' => 'Lorem Ipsum'
        ]);
        // Show JSON output
        //->dump();

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
