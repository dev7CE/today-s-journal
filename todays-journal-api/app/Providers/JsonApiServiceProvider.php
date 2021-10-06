<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class JsonApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() { }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('allowedSorts', function ($allowedSorts)
        {
            if(request()->filled('sort'))
            {
                $sortFields = explode(',', request()->sort);
    
                foreach ($sortFields as $sortField) 
                {
                    $sortDirection = Str::of($sortField)->startsWith('-') 
                    ? 'desc' : 'asc';
                    
                    $sortField = ltrim($sortField, "-");
    
                    abort_unless(in_array($sortField, $allowedSorts), 400);
                    
                    /** @var Builder $this */
                    $this->orderBy($sortField, $sortDirection);
                }
            } 
            return $this;
        });

        Builder::macro('jsonPaginate', function ()
        {
            /** @var Builder $this */
            return $this->paginate(
                $perPage = request('page.size', 15), 
                $columns = ['*'], 
                $pageName = 'page[number]', 
                $page = request('page.number', 1)
            )->appends(request()->only('sort', 'page.size'));
            
        });
    }
}
