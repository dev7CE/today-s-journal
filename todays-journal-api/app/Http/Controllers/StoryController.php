<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoryResource;
use App\Story;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        // Valid for ListStoriesTest->$response->assertSee(json_structure)
        // return $story;
        // Valid for ListStoriesTest->$response->assertExactJson(json_structure)
        return response()->json([
            'data' => [
                'type' => 'stories',
                'id' => (string) $story->getRouteKey(),
                'attributes' => [
                    'title' => $story->title,
                    'url' => $story->url,
                    'content' => $story->content
                ],
                'links' => [
                    'self' => url('/api/v1/stories/'.$story->getRouteKey()) 
                ]
            ]
        ]);
    }

}
