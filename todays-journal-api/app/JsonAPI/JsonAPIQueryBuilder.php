<?php

namespace App\JsonAPI;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class JsonAPIQueryBuilder { 

    /**
     * MACRO.
     * Sort Model Resources based on JSON:API Spec.
     * 
     * @return Closure
     */
    public function allowedSorts (): Closure
    {
        return function ($allowedSorts)
        {
            /** @var Builder $this */
            if(request()->filled('sort'))
            {
                $sortFields = explode(',', request()->sort);
    
                foreach ($sortFields as $sortField) 
                {
                    $sortDirection = Str::of($sortField)->startsWith('-') 
                    ? 'desc' : 'asc';
                    
                    $sortField = ltrim($sortField, "-");
    
                    abort_unless(in_array($sortField, $allowedSorts), 400);
                    
                    $this->orderBy($sortField, $sortDirection);
                }
            } 
            return $this;
        };
    }

    /**
     * Paginate Model Resources based on JSON:API Spec.
     * 
     * @return Closure
     */
    public function jsonPaginate (): Closure
    {
        return function ()
        {
            /** @var Builder $this */
            return $this->paginate(
                $perPage = request('page.size', 15), 
                $columns = ['*'], 
                $pageName = 'page[number]', 
                $page = request('page.number', 1)
            )->appends(request()->only('sort', 'page.size'));
            
        };
    }
}
