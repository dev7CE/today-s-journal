<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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
     * Get the route key for the model.
     * OVERRIDEN FUNCTION TO SET URL (slug) as route key.
     * 
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'url';
    }

    /**
     * Get the user that owns the story.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Query Scope. Filter Stories by Year.
     * 
     * @param string $year the given year
     * @return void
     */
    public function scopeYear(Builder $query, $year)
    {
        $query->whereYear('created_at', $year);
    }

    /**
     * Query Scope. Filter Stories by Month.
     * 
     * @param string $month the given month
     * @return void
     */
    public function scopeMonth(Builder $query, $month)
    {
        $query->whereMonth('created_at', $month);
    }
}
