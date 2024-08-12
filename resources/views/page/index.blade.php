<?php
$sort = empty($sort) || ! is_array($sort) ? [] : $sort;

$filters = empty($filters) || ! is_array($filters) ? [] : $filters;

$validated = empty($validated) || ! is_array($validated) ? [] : $validated;

$withTableColumns = [
    'page_type' => [
        'hide-sm' => false,
        'label' => 'Page Type',
    ],
    'created_by_id' => [
        'hide-sm' => true,
        'label' => 'Created by id',
    ],
    'modified_by_id' => [
        'hide-sm' => true,
        'label' => 'Modified by id',
    ],
    'owned_by_id' => [
        'hide-sm' => true,
        'label' => 'Owned by id',
    ],
    'parent_id' => [
        'hide-sm' => true,
        'label' => 'Parent id',
    ],
    'matrix_id' => [
        'hide-sm' => true,
        'label' => 'Matrix id',
    ],
    'locale' => [
        'hide-sm' => true,
        'linkType' => null,
        'linkRoute' => null,
        'label' => 'Locale',
    ],
    'label' => [
        'hide-sm' => true,
        'linkType' => null,
        'linkRoute' => null,
        'label' => 'Label',
    ],
    'title' => [
        'hide-sm' => false,
        'linkType' => 'id',
        'linkRoute' => sprintf('%1$s.show', $meta['info']['model_route']),
        'label' => 'Title',
    ],
    'byline' => [
        'hide-sm' => true,
        'linkType' => null,
        'linkRoute' => null,
        'label' => 'Byline',
    ],
    'slug' => [
        'hide-sm' => false,
        'linkType' => null,
        'linkRoute' => null,
        'label' => 'Slug',
    ],
    'url' => [
        'hide-sm' => true,
        'linkType' => null,
        'linkRoute' => null,
        'label' => 'Url',
    ],
    'description' => [
        'hide-sm' => true,
        'linkType' => null,
        'linkRoute' => null,
        'label' => 'Description',
    ],
    'introduction' => [
        'hide-sm' => true,
        'linkType' => null,
        'linkRoute' => null,
        'label' => 'Introduction',
    ],
    'content' => [
        'hide-sm' => true,
        'linkType' => null,
        'linkRoute' => null,
        'label' => 'Content',
    ],
    'summary' => [
        'hide-sm' => true,
        'linkType' => null,
        'linkRoute' => null,
        'label' => 'Summary',
    ],
    'active' => [
        'hide-sm' => false,
        'flag' => true,
        'label' => 'Active',
        'onTrueClass' => 'fa-solid fa-person-running',
    ],
    'canceled' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Canceled',
        'onTrueClass' => 'fa-solid fa-ban text-warning',
    ],
    'closed' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Closed',
        'onTrueClass' => 'fa-solid fa-xmark',
    ],
    'completed' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Completed',
        'onTrueClass' => 'fa-solid fa-check',
    ],
    'cron' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Cron',
        'onTrueClass' => 'fa-regular fa-clock',
    ],
    'duplicate' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Duplicate',
        'onTrueClass' => 'fa-solid fa-clone',
    ],
    'fixed' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Fixed',
        'onTrueClass' => 'fa-solid fa-wrench',
    ],
    'flagged' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Flagged',
        'onTrueClass' => 'fa-solid fa-flag',
    ],
    'internal' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Internal',
        'onTrueClass' => 'fa-solid fa-server',
    ],
    'is_external' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Is external',
        'onTrueClass' => 'fa-solid fa-close',
    ],
    'is_redirect' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Is redirect',
        'onTrueClass' => 'fa-solid fa-close',
    ],
    'locked' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Locked',
        'onTrueClass' => 'fa-solid fa-lock text-warning',
    ],
    'pending' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Pending',
        'onTrueClass' => 'fa-solid fa-circle-pause text-warning',
    ],
    'planned' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Planned',
        'onTrueClass' => 'fa-solid fa-circle-pause text-success',
    ],
    'prioritized' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Prioritized',
        'onTrueClass' => 'fa-solid fa-triangle-exclamation text-success',
    ],
    'problem' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Problem',
        'onTrueClass' => 'fa-solid fa-triangle-exclamation text-danger',
    ],
    'published' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Published',
        'onTrueClass' => 'fa-solid fa-book',
    ],
    'released' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Released',
        'onTrueClass' => 'fa-solid fa-dove',
    ],
    'resolved' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Resolved',
        'onTrueClass' => 'fa-solid fa-check-double text-success',
    ],
    'retired' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Retired',
        'onTrueClass' => 'fa-solid fa-chair text-success',
    ],
    'sitemap' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Sitemap',
        'onTrueClass' => 'fa-solid fa-sitemap text-success',
    ],
    'suspended' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Suspended',
        'onTrueClass' => 'fa-solid fa-hand text-danger',
    ],
    'unknown' => [
        'hide-sm' => true,
        'flag' => true,
        'label' => 'Unknown',
        'onTrueClass' => 'fa-solid fa-question text-warning',
    ],
    'created_at' => [
        'hide-sm' => true,
        'label' => 'Created at',
    ],
    'updated_at' => [
        'hide-sm' => true,
        'label' => 'Updated at',
    ],
    'canceled_at' => [
        'hide-sm' => true,
        'label' => 'Canceled at',
    ],
    'closed_at' => [
        'hide-sm' => true,
        'label' => 'Closed at',
    ],
    'embargo_at' => [
        'hide-sm' => true,
        'label' => 'Embargo at',
    ],
    'fixed_at' => [
        'hide-sm' => true,
        'label' => 'Fixed at',
    ],
    'planned_end_at' => [
        'hide-sm' => true,
        'label' => 'Planned end at',
    ],
    'planned_start_at' => [
        'hide-sm' => true,
        'label' => 'Planned start at',
    ],
    'postponed_at' => [
        'hide-sm' => true,
        'label' => 'Postponed at',
    ],
    'published_at' => [
        'hide-sm' => true,
        'label' => 'Published at',
    ],
    'released_at' => [
        'hide-sm' => true,
        'label' => 'Released at',
    ],
    'resumed_at' => [
        'hide-sm' => true,
        'label' => 'Resumed at',
    ],
    'resolved_at' => [
        'hide-sm' => true,
        'label' => 'Resolved at',
    ],
    'suspended_at' => [
        'hide-sm' => true,
        'label' => 'Suspended at',
    ],
    'timer_end_at' => [
        'hide-sm' => true,
        'label' => 'Timer end at',
    ],
    'timer_start_at' => [
        'hide-sm' => true,
        'label' => 'Timer start at',
    ],
    'gids' => [
        'hide-sm' => true,
        'label' => 'Gids',
        'onTrueClass' => '',
    ],
    'po' => [
        'hide-sm' => true,
        'label' => 'Po',
        'onTrueClass' => '',
    ],
    'pg' => [
        'hide-sm' => true,
        'label' => 'Pg',
        'onTrueClass' => '',
    ],
    'pw' => [
        'hide-sm' => true,
        'label' => 'Pw',
        'onTrueClass' => '',
    ],
    'only_admin' => [
        'hide-sm' => true,
        'label' => 'Only admin',
        'onTrueClass' => 'fa-solid fa-user-gear',
    ],
    'only_user' => [
        'hide-sm' => true,
        'label' => 'Only user',
        'onTrueClass' => 'fa-solid fa-user',
    ],
    'only_guest' => [
        'hide-sm' => true,
        'label' => 'Only guest',
        'onTrueClass' => 'fa-solid fa-person-rays',
    ],
    'allow_public' => [
        'hide-sm' => true,
        'label' => 'Allow public',
        'onTrueClass' => 'fa-solid fa-users-line',
    ],
    'status' => [
        'hide-sm' => true,
        'label' => 'Status',
    ],
    'rank' => [
        'hide-sm' => true,
        'label' => 'Rank',
    ],
    'size' => [
        'hide-sm' => true,
        'label' => 'Size',
    ],
    'revision' => [
        'hide-sm' => true,
        'label' => 'Revision',
    ],
    'redirect_delay' => [
        'hide-sm' => true,
        'label' => 'Redirect delay',
    ],
    'status_code' => [
        'hide-sm' => true,
        'label' => 'Status code',
    ],
    'route' => [
        'hide-sm' => true,
        'label' => 'Route',
    ],
    'matrix' => [
        'hide-sm' => true,
        'label' => 'Matrix',
    ],
    'x' => [
        'hide-sm' => true,
        'label' => 'X',
    ],
    'y' => [
        'hide-sm' => true,
        'label' => 'Y',
    ],
    'z' => [
        'hide-sm' => true,
        'label' => 'Z',
    ],
    'r' => [
        'hide-sm' => true,
        'label' => 'R',
    ],
    'theta' => [
        'hide-sm' => true,
        'label' => 'Theta',
    ],
    'rho' => [
        'hide-sm' => true,
        'label' => 'Rho',
    ],
    'phi' => [
        'hide-sm' => true,
        'label' => 'Phi',
    ],
    'elevation' => [
        'hide-sm' => true,
        'label' => 'Elevation',
    ],
    'latitude' => [
        'hide-sm' => true,
        'label' => 'Latitude',
    ],
    'longitude' => [
        'hide-sm' => true,
        'label' => 'Longitude',
    ],
];

$standardColumns = [
    'title',
    'slug',
    'active',
    'created_at',
    'updated_at',
    'page_type',
];

if (empty($validated['columns']) || $validated['columns'] !== 'all') {
    $columns = Illuminate\Support\Arr::only($withTableColumns, $standardColumns);
} else {
    $columns = $withTableColumns;
}

?>

@extends('playground::layouts.resource.index', [
    'withTableColumns' => $columns,
])
