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
            'data' => [
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
