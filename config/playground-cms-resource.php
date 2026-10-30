<?php

/**
 * Playground
 */

declare(strict_types=1);
use Illuminate\Database\Eloquent\Model;
use Playground\Auth\Policies\Policy;
use Playground\Cms\Models\Page;
use Playground\Cms\Models\PageRevision;
use Playground\Cms\Models\Snippet;
use Playground\Cms\Models\SnippetRevision;
use Playground\Cms\Models\Tag;
use Playground\Cms\Models\Tagged;
use Playground\Cms\Resource\Policies\PagePolicy;
use Playground\Cms\Resource\Policies\SnippetPolicy;
use Playground\Cms\Resource\Policies\TaggedPolicy;
use Playground\Cms\Resource\Policies\TagPolicy;

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
 *       matrix: array{
 *           enabled: bool,
 *       },
 *       middleware: array{
 *           default: string|string[],
 *           auth: string|string[],
 *           guest: string|string[]
 *       },
 *       policies: array<
 *           class-string<Model>,
 *           class-string<Policy>
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
 *           tags: bool,
 *           tagged: bool,
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
    | Matrix
    |--------------------------------------------------------------------------
    |
    |
    */

    'matrix' => [
        'enabled' => (bool) env('PLAYGROUND_CMS_RESOURCE_MATRIX_ENABLED', false),
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
        Page::class => PagePolicy::class,
        PageRevision::class => PagePolicy::class,
        Snippet::class => SnippetPolicy::class,
        SnippetRevision::class => SnippetPolicy::class,
        Tag::class => TagPolicy::class,
        Tagged::class => TaggedPolicy::class,
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
        'tags' => (bool) env('PLAYGROUND_CMS_RESOURCE_ROUTES_TAGS', true),
        'tagged' => (bool) env('PLAYGROUND_CMS_RESOURCE_ROUTES_TAGGED', true),
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
            'playground-cms-resource:tag:*',
            'playground-cms-resource:tagged:*',
        ],
        'user' => [
            'playground-cms-resource:page:view',
            'playground-cms-resource:page:viewAny',
            'playground-cms-resource:snippet:view',
            'playground-cms-resource:snippet:viewAny',
            'playground-cms-resource:tag:view',
            'playground-cms-resource:tag:viewAny',
            'playground-cms-resource:tagged:view',
            'playground-cms-resource:tagged:viewAny',
        ],
    ],
];
