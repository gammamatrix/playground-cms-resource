<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Cms\Models\Tag;

/*
|--------------------------------------------------------------------------
| CMS Resource Routes: Tag
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/cms/tag',
    'middleware' => config('playground-cms-resource.middleware.default'),
    'namespace' => '\Playground\Cms\Resource\Http\Controllers',
], function () {

    Route::get('/{tag:slug}', [
        'as' => 'playground.cms.resource.tags.slug',
        'uses' => 'TagController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'resource/cms/tags',
    'middleware' => config('playground-cms-resource.middleware.default'),
    'namespace' => '\Playground\Cms\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.cms.resource.tags',
        'uses' => 'TagController@index',
    ])->can('index', Tag::class);

    Route::post('/index', [
        'as' => 'playground.cms.resource.tags.index',
        'uses' => 'TagController@index',
    ])->can('index', Tag::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.cms.resource.tags.create',
        'uses' => 'TagController@create',
    ])->can('create', Tag::class);

    Route::get('/edit/{tag}', [
        'as' => 'playground.cms.resource.tags.edit',
        'uses' => 'TagController@edit',
    ])->whereUuid('tag')->can('edit', 'tag');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.cms.resource.tags.go',
    //     'uses' => 'TagController@go',
    // ]);

    Route::get('/{tag}', [
        'as' => 'playground.cms.resource.tags.show',
        'uses' => 'TagController@show',
    ])->whereUuid('tag')->can('detail', 'tag')->withTrashed();

    // API

    Route::put('/lock/{tag}', [
        'as' => 'playground.cms.resource.tags.lock',
        'uses' => 'TagController@lock',
    ])->whereUuid('tag')->can('lock', 'tag');

    Route::delete('/lock/{tag}', [
        'as' => 'playground.cms.resource.tags.unlock',
        'uses' => 'TagController@unlock',
    ])->whereUuid('tag')->can('unlock', 'tag');

    Route::delete('/{tag}', [
        'as' => 'playground.cms.resource.tags.destroy',
        'uses' => 'TagController@destroy',
    ])->whereUuid('tag')->can('delete', 'tag')->withTrashed();

    Route::put('/restore/{tag}', [
        'as' => 'playground.cms.resource.tags.restore',
        'uses' => 'TagController@restore',
    ])->whereUuid('tag')->can('restore', 'tag')->withTrashed();

    Route::post('/', [
        'as' => 'playground.cms.resource.tags.post',
        'uses' => 'TagController@store',
    ])->can('store', Tag::class);

    // Route::put('/', [
    //     'as' => 'playground.cms.resource.tags.put',
    //     'uses' => 'TagController@store',
    // ])->can('store', Playground\Cms\Models\Tag::class);
    //
    // Route::put('/{tag}', [
    //     'as' => 'playground.cms.resource.tags.put.id',
    //     'uses' => 'TagController@store',
    // ])->whereUuid('tag')->can('update', 'tag');

    Route::patch('/{tag}', [
        'as' => 'playground.cms.resource.tags.patch',
        'uses' => 'TagController@update',
    ])->whereUuid('tag')->can('update', 'tag');
});
