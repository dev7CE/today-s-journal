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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('stories', [StoryController::class, 'index'])
    ->name('api.v1.stories.index');
Route::get('stories/{story}', [StoryController::class, 'show'])
    ->name('api.v1.stories.show');
Route::post('stories', [StoryController::class, 'store'])
    ->name('api.v1.stories.store');
