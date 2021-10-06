<?php

namespace App\Providers;

use App\JsonAPI\JsonAPIQueryBuilder;
use App\JsonAPI\JsonAPITestResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;

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
        // Builder::macro('allowedSorts', function ($allowedSorts) { /** Closure code... */ });
        // Builder::macro('jsonPaginate', function (){ /** Closure code... */});
        
        // QueryBuilder Macros
        Builder::mixin(new JsonAPIQueryBuilder);
        // TestResponse Macros
        TestResponse::mixin(new JsonAPITestResponse());
    }
}
