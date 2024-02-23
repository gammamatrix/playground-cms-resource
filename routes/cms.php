<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CMS API Routes
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/cms',
    'middleware' => config('playground-cms-resource.middleware.default'),
    'namespace' => '\Playground\Cms\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.cms.resource',
        'uses' => 'IndexController@index',
    ])->can('index', Playground\Cms\Models\Page::class);
});
