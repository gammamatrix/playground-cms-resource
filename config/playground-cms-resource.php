<?php

/**
 * Playground
 */

declare(strict_types=1);

/**
 * Playground: CMS Resource Configuration and Environment Variables
 *
 * @return array{
 *       about: bool,
 *       layout: string,
 *       load: array{
 *           policies: bool,
 *           routes: bool,
 *           translations: bool,
 *           views: bool
 *       },
 *       middleware: array{
 *           default: string|string[],
 *           auth: string|string[],
 *           guest: string|string[]
 *       },
 *       policies: array<
 *           class-string<\Illuminate\Database\Eloquent\Model>,
 *           class-string<\Playground\Auth\Policies\Policy>
 *       >,
 *       revisions: array{
 *           options: bool,
 *           pages: bool,
 *           snippets: bool,
 *       },
 *       routes: array{
 *           cms: bool,
 *           pages: bool,
 *           snippets: bool,
 *       },
 *       blade: string,
 *       cache: array{
 *           enable: bool,
 *           page: bool,
 *           page_store: string,
 *           page_ttl: int,
 *           snippet: bool,
 *           snippet_store: string,
 *           snippet_ttl: int,
 *       },
 *       abilities: array<string, string[]>,
 *       sitemap: array{
 *            enable: bool,
 *            guest: bool,
 *            user: bool,
 *            view: string
 *       }
 *   }
 */
return [

    /*
    |--------------------------------------------------------------------------
    | About Information
    |--------------------------------------------------------------------------
    |
    | By default, information will be displayed about this package when using:
    |
    | `artisan about`
    |
    */

    'about' => (bool) env('PLAYGROUND_CMS_RESOURCE_ABOUT', true),

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    |
    | By default, translations and views are loaded.
    |
    */

    'load' => [
        'policies' => (bool) env('PLAYGROUND_CMS_RESOURCE_LOAD_POLICIES', true),
        'routes' => (bool) env('PLAYGROUND_CMS_RESOURCE_LOAD_ROUTES', true),
        'translations' => (bool) env('PLAYGROUND_CMS_RESOURCE_LOAD_TRANSLATIONS', true),
        'views' => (bool) env('PLAYGROUND_CMS_RESOURCE_LOAD_VIEWS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    |
    */

    'middleware' => [
        'default' => env('PLAYGROUND_CMS_RESOURCE_MIDDLEWARE_DEFAULT', ['web']),
        'auth' => env('PLAYGROUND_CMS_RESOURCE_MIDDLEWARE_AUTH', ['web', 'auth']),
        'guest' => env('PLAYGROUND_CMS_RESOURCE_MIDDLEWARE_GUEST', ['web']),
    ],

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    |
    */

    'policies' => [
        Playground\Cms\Models\Page::class => Playground\Cms\Resource\Policies\PagePolicy::class,
        Playground\Cms\Models\PageRevision::class => Playground\Cms\Resource\Policies\PagePolicy::class,
        Playground\Cms\Models\Snippet::class => Playground\Cms\Resource\Policies\SnippetPolicy::class,
        Playground\Cms\Models\SnippetRevision::class => Playground\Cms\Resource\Policies\SnippetPolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Revisions
    |--------------------------------------------------------------------------
    |
    |
    */

    'revisions' => [
        'optional' => (bool) env('PLAYGROUND_CMS_RESOURCE_REVISIONS_OPTIONAL', false),
        'pages' => (bool) env('PLAYGROUND_CMS_RESOURCE_REVISIONS_PAGES', true),
        'snippets' => (bool) env('PLAYGROUND_CMS_RESOURCE_REVISIONS_SNIPPETS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    'routes' => [
        'cms' => (bool) env('PLAYGROUND_CMS_RESOURCE_ROUTES_CMS', true),
        'pages' => (bool) env('PLAYGROUND_CMS_RESOURCE_ROUTES_PAGES', true),
        'snippets' => (bool) env('PLAYGROUND_CMS_RESOURCE_ROUTES_SNIPPETS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap
    |--------------------------------------------------------------------------
    |
    |
    */

    'sitemap' => [
        'enable' => (bool) env('PLAYGROUND_CMS_RESOURCE_SITEMAP_ENABLE', true),
        'guest' => (bool) env('PLAYGROUND_CMS_RESOURCE_SITEMAP_GUEST', true),
        'user' => (bool) env('PLAYGROUND_CMS_RESOURCE_SITEMAP_USER', true),
        'view' => env('PLAYGROUND_CMS_RESOURCE_SITEMAP_VIEW', 'playground-cms-resource::sitemap'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    |
    */

    'blade' => env('PLAYGROUND_CMS_RESOURCE_BLADE', 'playground-cms-resource::'),

    /*
    |--------------------------------------------------------------------------
    | Abilities
    |--------------------------------------------------------------------------
    |
    |
    */

    'abilities' => [
        'admin' => [
            'playground-cms-resource:*',
        ],
        'manager' => [
            'playground-cms-resource:page:*',
            'playground-cms-resource:snippet:*',
        ],
        'user' => [
            'playground-cms-resource:page:view',
            'playground-cms-resource:page:viewAny',
            'playground-cms-resource:snippet:view',
            'playground-cms-resource:snippet:viewAny',
        ],
    ],
];
