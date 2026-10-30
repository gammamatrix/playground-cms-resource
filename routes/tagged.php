<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Cms\Models\Tagged;

/*
|--------------------------------------------------------------------------
| CMS Resource Routes: Tagged
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/cms/tagged',
    'middleware' => config('playground-cms-resource.middleware.default'),
    'namespace' => '\Playground\Cms\Resource\Http\Controllers',
], function () {

    // API

    Route::delete('/{tagged}', [
        'as' => 'playground.cms.resource.tagged.destroy',
        'uses' => 'TaggedController@destroy',
    ])->whereUuid('tagged')->can('delete', 'tagged');

    Route::post('/', [
        'as' => 'playground.cms.resource.tagged.post',
        'uses' => 'TaggedController@store',
    ])->can('store', Tagged::class);
});
