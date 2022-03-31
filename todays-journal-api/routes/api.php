<?php

use App\Http\Controllers\StoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Auth')->group(function(){
    Route::post('login', 'LoginController')
        ->withoutMiddleware([
            'validate.json.api.document',
            'validate.json.api.headers',
        ])->name('api.v1.auth.login');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('stories', [StoryController::class, 'index'])
    ->name('api.v1.stories.index');
Route::get('stories/{story}', [StoryController::class, 'show'])
    ->name('api.v1.stories.show');
Route::patch('stories/{story}', [StoryController::class, 'update'])
    ->name('api.v1.stories.update');
Route::post('stories', [StoryController::class, 'store'])
    ->name('api.v1.stories.store')
    ->middleware('auth');
Route::delete('stories/{story}', [StoryController::class, 'destroy'])
    ->name('api.v1.stories.destroy');
