<?php
$user = \Illuminate\Support\Facades\Auth::user();

$viewPages = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-cms-resource:page:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewSnippets = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-cms-resource:snippet:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();

$viewTags = \Playground\Auth\Facades\Can::access($user, [
    'allow' => false,
    'any' => true,
    'privilege' => 'playground-cms-resource:tag:viewAny',
    'roles' => ['admin', 'manager', 'publisher'],
])->allowed();


if (!$viewPages && !$viewSnippets && !$viewTags) {
    return;
}
?>
<div class="card my-1">
    <div class="card-body">
        <h2>CMS</h2>

        <div class="row">
            <div class="col-sm-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        Content Management System
                        <small class="text-muted"
                            >pages, snippets and tags</small
                        >
                    </div>
                    <ul class="list-group list-group-flush">
                        @if ($viewPages)
                            <a
                                href="{{ route('playground.cms.resource.pages') }}"
                                class="list-group-item list-group-item-action"
                            >
                                Pages
                            </a>
                        @endif

                        @if ($viewSnippets)
                            <a
                                href="{{ route('playground.cms.resource.snippets') }}"
                                class="list-group-item list-group-item-action"
                            >
                                Snippets
                            </a>
                        @endif

                        @if ($viewTags)
                            <a
                                href="{{ route('playground.cms.resource.tags') }}"
                                class="list-group-item list-group-item-action"
                            >
                                Tags
                            </a>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
