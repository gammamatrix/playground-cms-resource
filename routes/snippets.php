<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CMS Routes: Snippet
|--------------------------------------------------------------------------
|
|
*/
Route::group([
    'prefix' => 'resource/cms/snippet',
    'middleware' => config('playground-cms-resource.middleware.default'),
    'namespace' => '\Playground\Cms\Resource\Http\Controllers',
], function () {

    Route::get('/{snippet:slug}', [
        'as' => 'playground.cms.resource.snippets.slug',
        'uses' => 'SnippetController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'resource/cms/snippets',
    'middleware' => config('playground-cms-resource.middleware.default'),
    'namespace' => '\Playground\Cms\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.cms.resource.snippets',
        'uses' => 'SnippetController@index',
    ])->can('index', Playground\Cms\Models\Snippet::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.cms.resource.snippets.create',
        'uses' => 'SnippetController@create',
    ])->can('create', Playground\Cms\Models\Snippet::class);

    Route::get('/edit/{snippet}', [
        'as' => 'playground.cms.resource.snippets.edit',
        'uses' => 'SnippetController@edit',
    ])->whereUuid('snippet')
        ->can('edit', 'snippet');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.cms.resource.snippets.go',
    //     'uses' => 'SnippetController@go',
    // ]);

    Route::get('/{snippet}', [
        'as' => 'playground.cms.resource.snippets.show',
        'uses' => 'SnippetController@show',
    ])->whereUuid('snippet')
        ->can('detail', 'snippet');

    Route::get('/{snippet}/revisions', [
        'as' => 'playground.cms.resource.snippets.revisions',
        'uses' => 'SnippetController@revisions',
    ])->whereUuid('snippet')
        ->can('revisions', 'snippet');

    Route::get('/revision/{snippet_revision}', [
        'as' => 'playground.cms.resource.snippets.revision',
        'uses' => 'SnippetController@revision',
    ])->whereUuid('snippet')
        ->can('viewRevision', 'snippet_revision');

    Route::put('/revision/{snippet_revision}', [
        'as' => 'playground.cms.resource.snippets.revision.restore',
        'uses' => 'SnippetController@restoreRevision',
    ])->whereUuid('snippet_revision')
        ->can('restoreRevision', 'snippet_revision');

    // API

    Route::put('/lock/{snippet}', [
        'as' => 'playground.cms.resource.snippets.lock',
        'uses' => 'SnippetController@lock',
    ])->whereUuid('snippet')
        ->can('lock', 'snippet');

    Route::delete('/lock/{snippet}', [
        'as' => 'playground.cms.resource.snippets.unlock',
        'uses' => 'SnippetController@unlock',
    ])->whereUuid('snippet')
        ->can('unlock', 'snippet');

    Route::delete('/{snippet}', [
        'as' => 'playground.cms.resource.snippets.destroy',
        'uses' => 'SnippetController@destroy',
    ])->whereUuid('snippet')
        ->can('delete', 'snippet')
        ->withTrashed();

    Route::put('/restore/{snippet}', [
        'as' => 'playground.cms.resource.snippets.restore',
        'uses' => 'SnippetController@restore',
    ])->whereUuid('snippet')
        ->can('restore', 'snippet')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.cms.resource.snippets.post',
        'uses' => 'SnippetController@store',
    ])->can('store', Playground\Cms\Models\Snippet::class);

    // Route::put('/', [
    //     'as'   => 'playground.cms.resource.snippets.put',
    //     'uses' => 'SnippetController@store',
    // ])->can('store', \Playground\Cms\Models\Snippet::class);
    //
    // Route::put('/{snippet}', [
    //     'as'   => 'playground.cms.resource.snippets.put.id',
    //     'uses' => 'SnippetController@store',
    // ])->whereUuid('snippet')->can('update', 'snippet');

    Route::patch('/{snippet}', [
        'as' => 'playground.cms.resource.snippets.patch',
        'uses' => 'SnippetController@update',
    ])->whereUuid('snippet')->can('update', 'snippet');
});
