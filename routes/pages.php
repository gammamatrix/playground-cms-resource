<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CMS Routes: Page
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/cms/pages',
    'middleware' => config('playground-cms-resource.middleware.default'),
    'namespace' => '\Playground\Cms\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.cms.resource.pages',
        'uses' => 'PageController@index',
    ])->can('index', Playground\Cms\Models\Page::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.cms.resource.pages.create',
        'uses' => 'PageController@create',
    ])->can('create', Playground\Cms\Models\Page::class);

    Route::get('/edit/{page}', [
        'as' => 'playground.cms.resource.pages.edit',
        'uses' => 'PageController@edit',
    ])->whereUuid('page')
        ->can('edit', 'page');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.cms.resource.pages.go',
    //     'uses' => 'PageController@go',
    // ]);

    Route::get('/{page}', [
        'as' => 'playground.cms.resource.pages.show',
        'uses' => 'PageController@show',
    ])->whereUuid('page')
        ->can('detail', 'page');

    Route::get('/{page}/revisions', [
        'as' => 'playground.cms.resource.pages.revisions',
        'uses' => 'PageController@revisions',
    ])->whereUuid('page')
        ->can('revisions', 'page');

    Route::get('/revision/{page_revision}', [
        'as' => 'playground.cms.resource.pages.revision',
        'uses' => 'PageController@revision',
    ])->whereUuid('page')
        ->can('viewRevision', 'page_revision');

    Route::put('/revision/{page_revision}', [
        'as' => 'playground.cms.resource.pages.revision.restore',
        'uses' => 'PageController@restoreRevision',
    ])->whereUuid('page_revision')
        ->can('restoreRevision', 'page_revision');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.cms.resource.pages.slug',
    //     'uses' => 'PageController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.cms.resource.pages.store',
    //     'uses' => 'PageController@store',
    // ])->can('store', \Playground\Cms\Models\Page::class);

    // API

    Route::put('/lock/{page}', [
        'as' => 'playground.cms.resource.pages.lock',
        'uses' => 'PageController@lock',
    ])->whereUuid('page')
        ->can('lock', 'page');

    Route::delete('/lock/{page}', [
        'as' => 'playground.cms.resource.pages.unlock',
        'uses' => 'PageController@unlock',
    ])->whereUuid('page')
        ->can('unlock', 'page');

    Route::delete('/{page}', [
        'as' => 'playground.cms.resource.pages.destroy',
        'uses' => 'PageController@destroy',
    ])->whereUuid('page')
        ->can('delete', 'page')
        ->withTrashed();

    Route::put('/restore/{page}', [
        'as' => 'playground.cms.resource.pages.restore',
        'uses' => 'PageController@restore',
    ])->whereUuid('page')
        ->can('restore', 'page')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.cms.resource.pages.post',
        'uses' => 'PageController@store',
    ])->can('store', Playground\Cms\Models\Page::class);

    // Route::put('/', [
    //     'as'   => 'playground.cms.resource.pages.put',
    //     'uses' => 'PageController@store',
    // ])->can('store', \Playground\Cms\Models\Page::class);
    //
    // Route::put('/{page}', [
    //     'as'   => 'playground.cms.resource.pages.put.id',
    //     'uses' => 'PageController@store',
    // ])->whereUuid('page')->can('update', 'page');

    Route::patch('/{page}', [
        'as' => 'playground.cms.resource.pages.patch',
        'uses' => 'PageController@update',
    ])->whereUuid('page')->can('update', 'page');
});
