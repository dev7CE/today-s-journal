<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoryResource;
use App\Http\Resources\StoryCollection;
use App\Story;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoryController extends Controller
{
    
    // THE TEST FOR THIS ACTION WAS COMMITED IN:
    // Commit: 766e0e63b424bed047419a98d8c42b7459d98738
    // Name:
    // Refact: can_fecth_a_single_model function renamed
    /**
     * Display a listing of the resource.
     *
     */
    public function index():StoryCollection
    {
        // With default Model Collection
        // return StoryResource::collection(Story::all());
        // With default Model Collection MODIFIED
        return StoryCollection::make(Story::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Return 201 response
        // return response(null, 201);
        // Show $request data inputs
        // dd = Dump and Die 
        // dd($request->all());
        // Show attributes data inputs only
        // dd($request->input('data.attributes'));

        $request->validate([
            'data.attributes.title' => ['required','min:4'],
            'data.attributes.url' => ['required'],
            'data.attributes.content' => ['required']
        ]);

        $story = Story::create([
            // This will fail if request does not 
            // include all attributes
            'title' => $request->input('data.attributes.title'),
            'url' => $request->input('data.attributes.url'),
            'content' => $request->input('data.attributes.content')
        ]);
        
        // Resource object detects if model 
        // was recently created, will return 201 code.
        return StoryResource::make($story);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story):StoryResource
    {
        // Valid for ListStoriesTest->$response->assertSee(json_structure)
        // return $story;
        // Valid for ListStoriesTest->$response->assertExactJson(json_structure)
        // return response()->json(json_structure);
        // Using Laravel Resources
        return StoryResource::make($story);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story)
    {
        $request->validate([
            'data.attributes.title' => ['required','min:4'],
            'data.attributes.url' => ['required'],
            'data.attributes.content' => ['required']
        ]);

        $story->update([
            'title' => $request->input('data.attributes.title', $story->title),
            'url' => $request->input('data.attributes.url', $story->url),
            'content' => $request->input('data.attributes.content', $story->content)
        ]);

        return StoryResource::make($story);
    }
}
