<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            /*
            Laravel 7:
            If JSON structure is:
                'data'=>[
                    'type'=>'',
                    'id'=>''
                    ...
                ]
            'can_fetch_all_stories' test will fail

            This is because 'data' its used wrap the model collection (see JsonResource). 
            If we use the structure above for fetch a single model, it works,
            however it does not work with fetch an array of model items, 
            because every single item into array will contain the "data" meta,
            this meta is located in the first level of JSON:API structure and it must not
            be in array items if we sent a collection to this Resource . 
            */
            'type' => 'stories',
            'id' => (string) $this->resource->getRouteKey(),
            'attributes' => [
                'title' => $this->resource->title,
                'url' => $this->resource->url,
                'content' => $this->resource->content
            ],
            'links' => [
                'self' => route('api.v1.stories.show', $this->resource),
            ]
        ];
    }
}
