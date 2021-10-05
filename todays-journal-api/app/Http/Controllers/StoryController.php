<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveStoryRequest;
use App\Http\Resources\StoryResource;
use App\Http\Resources\StoryCollection;
use App\Story;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    
    // THE TEST FOR THIS ACTION WAS COMMITED IN:
    // Commit: 766e0e63b424bed047419a98d8c42b7459d98738
    // Name:
    // Refact: can_fecth_a_single_model function renamed
    /**
     * Display a listing of the resource.
     * @return StoryCollection
     */
    public function index(Request $request):StoryCollection
    {
        // dd($request->sort);
        // dd(explode(',', $request->sort));
        $stories = Story::query();

        if($request->filled('sort'))
        {
            $sortFields = explode(',', $request->sort);

            $allowedSorts = ['title', 'content'];

            foreach ($sortFields as $sortField) 
            {
                $sortDirection = Str::of($sortField)->startsWith('-') 
                ? 'desc' : 'asc';
                
                $sortField = ltrim($sortField, "-");

                abort_unless(in_array($sortField, $allowedSorts), 400);

                $stories->orderBy($sortField, $sortDirection);
            }
        }
        return StoryCollection::make($stories->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveStoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveStoryRequest $request)
    {
        // Return 201 response
        // return response(null, 201);
        // Show $request data inputs
        // dd = Dump and Die 
        // dd($request->all());
        // Show attributes data inputs only
        // dd($request->input('data.attributes'));
        // Instead of get each input with request->input
        // function, we can use validated method to get 
        // the validated attribues (will not work beacause
        // function was overwritten).
        // dd($request->validated()['data']['attributes']);
        $story = Story::create($request->validated());
        
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
     * @param  \App\Http\Requests\SaveStoryRequest  $request
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(SaveStoryRequest $request, Story $story)
    {
        $story->update($request->validated());

        return StoryResource::make($story);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        $story->delete();
        // Using response to return No Content
        // return response('',204,[]);
        // Using noContent function
        return response()->noContent();
    }
}
