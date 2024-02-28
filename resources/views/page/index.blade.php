<?php
$sort = [];
$filters = [];
$validated = [];
// $paginator = null;
?>
@extends('playground::layouts.resource.index', [
    'withTableColumns' => [
        'title' => [
            'linkType' => 'id',
            'linkRoute' => sprintf('%1$s.show', $meta['info']['model_route']),
            'label' => 'Title',
        ],
        'label' => [
            'hide-sm' => true,
            'linkType' => 'id',
            // 'linkRoute' => sprintf('%1$s.show', $apiInfo['model_route']),
            'label' => 'Label',
        ],
        'slug' => [
            'hide-sm' => true,
            'linkType' => 'slug',
            'linkRoute' => sprintf('%1$s.slug', $meta['info']['model_route']),
            'label' => 'Slug',
        ],
        'active' => [
            'flag' => true,
            'label' => 'Active',
            'onTrueClass' => 'fas fa-check text-success',
        ],
        'locked' => [
            'flag' => true,
            'label' => 'Locked',
            'onTrueClass' => 'fas fa-lock text-success',
        ],
        'published' => [
            'flag' => true,
            'label' => 'Published',
            'onTrueClass' => 'fas fa-upload text-primary',
        ],
        'flagged' => [
            'hide-sm' => true,
            'flag' => true,
            'label' => 'Flagged',
            'onTrueClass' => 'fas fa-flag text-warning',
        ],
        'allow_public' => [
            'hide-sm' => true,
            'flag' => true,
            'label' => 'Public',
            // 'onFalseClass' => 'fas fa-user text-danger',
            'onTrueClass' => 'fas fa-users text-success',
        ],
        'only_admin' => [
            'hide-sm' => true,
            'flag' => true,
            'label' => 'Admin Only',
            // 'onFalseClass' => 'fas fa-user text-danger',
            'onTrueClass' => 'fas fa-user-shield text-danger',
        ],
        'only_user' => [
            'hide-sm' => true,
            'flag' => true,
            'label' => 'User Only',
            // 'onFalseClass' => 'fas fa-user text-danger',
            'onTrueClass' => 'fas fa-user text-warning',
        ],
        'only_guest' => [
            'hide-sm' => true,
            'flag' => true,
            'label' => 'Guest Only',
            // 'onFalseClass' => 'fas fa-user text-danger',
            'onTrueClass' => 'fas fa-user text-secondary',
        ],
        'parent_id' => [
            // 'linkType' => 'fk',
            // 'accessor' => 'parent',
            'property' => 'title',
            // 'linkRoute' => 'cms.resource.pages.show',
            'label' => 'Parent',
        ],
        'description' => [
            'hide-sm' => true,
            'label' => 'Description',
            'html' => true,
        ],
    ],
])
