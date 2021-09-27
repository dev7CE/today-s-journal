<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $user_id
 * @property string $title
 * @property string $url
 * @property string $content
 */
class Story extends Model
{
    // use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     * An empty array will make all attributes as 
     * not mass assignable
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the user that owns the story.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
