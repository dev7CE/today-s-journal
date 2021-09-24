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

}
