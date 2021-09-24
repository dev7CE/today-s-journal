<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StoryCollection extends ResourceCollection
{

    /*
    Works in Laravel 8:
    "data" => $this->collection

    By Convention, $this->collection property will take 
    ModelResource for every single model of collection given. If 
    both name ModelCollection and ModelResource dont match, test 
    will fall. The solution is change $collects property, by set 
    the ModelResource::class
    
    Works in Laravel 7:
    Set ModelResource Class to $collects property (like below) or 
    let ModelResource::collection use the this mapped collection: 

    "data" => ModelResource::collection($this->collection)

    This is because "$this->collection" does not 
    contain the JSON:API structure. Using ModelResource 
    Class can bring this structure to the model collection 
    send it to this Resource collection, in this case 
    Story::all() 
    */
    public $collects = StoryResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "data" => $this->collection,
            "links" => [
                'self' => route('api.v1.stories.index'),
            ]
        ];
    }
}
