<?php

return [
    'middleware' => [
        'default' => env('PLAYGROUND_CMS_RESOURCE_MIDDLEWARE_DEFAULT', ['web']),
        'auth' => env('PLAYGROUND_CMS_RESOURCE_MIDDLEWARE_AUTH', ['web', 'auth']),
        'guest' => env('PLAYGROUND_CMS_RESOURCE_MIDDLEWARE_GUEST', ['web']),
    ],
    'policies' => [
        Playground\Cms\Models\Snippet::class => Playground\Cms\Resource\Policies\SnippetPolicy::class,
        Playground\Cms\Models\SnippetRevision::class => Playground\Cms\Resource\Policies\SnippetPolicy::class,
        Playground\Cms\Models\Page::class => Playground\Cms\Resource\Policies\PagePolicy::class,
        Playground\Cms\Models\PageRevision::class => Playground\Cms\Resource\Policies\PagePolicy::class,
    ],
    'load' => [
        'policies' => (bool) env('PLAYGROUND_CMS_RESOURCE_LOAD_POLICIES', true),
        'routes' => (bool) env('PLAYGROUND_CMS_RESOURCE_LOAD_ROUTES', true),
        'translations' => (bool) env('PLAYGROUND_CMS_RESOURCE_LOAD_TRANSLATIONS', true),
        'views' => (bool) env('PLAYGROUND_CMS_RESOURCE_LOAD_VIEWS', true),
    ],
    'revisions' => [
        'optional' => (bool) env('PLAYGROUND_CMS_RESOURCE_ROUTES_OPTIONAL', false),
        'pages' => (bool) env('PLAYGROUND_CMS_RESOURCE_REVISIONS_PAGES', true),
        'snippets' => (bool) env('PLAYGROUND_CMS_RESOURCE_REVISIONS_SNIPPETS', true),
    ],
    'routes' => [
        'cms' => (bool) env('PLAYGROUND_CMS_RESOURCE_ROUTES_CMS', true),
        'snippets' => (bool) env('PLAYGROUND_CMS_RESOURCE_ROUTES_SNIPPETS', true),
        'pages' => (bool) env('PLAYGROUND_CMS_RESOURCE_ROUTES_PAGES', true),
    ],
    'sitemap' => [
        'enable' => (bool) env('PLAYGROUND_CMS_RESOURCE_SITEMAP_ENABLE', true),
        'guest' => (bool) env('PLAYGROUND_CMS_RESOURCE_SITEMAP_GUEST', true),
        'user' => (bool) env('PLAYGROUND_CMS_RESOURCE_SITEMAP_USER', true),
        'view' => env('PLAYGROUND_CMS_RESOURCE_SITEMAP_VIEW', 'playground-cms-resource::sitemap'),
    ],
    'blade' => env('PLAYGROUND_CMS_RESOURCE_BLADE', 'playground-cms-resource::'),

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
        // 'guest' => [
        //     'deny',
        // ],
        // 'guest' => [
        //     'app:view',

        //     'playground:view',

        //     'playground-auth:logout',
        //     'playground-auth:reset-password',

        //     'playground-cms-resource:page:view',
        //     'playground-cms-resource:page:viewAny',
        //     'playground-cms-resource:snippet:view',
        //     'playground-cms-resource:snippet:viewAny',
        // ],
    ],
];
