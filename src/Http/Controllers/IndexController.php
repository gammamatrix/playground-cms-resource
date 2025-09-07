<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Cms\Resource\Http\Controllers;

use Illuminate\View\View;

/**
 * \Playground\Cms\Resource\Http\Controllers\IndexController
 */
class IndexController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'module_label' => 'CMS',
        'module_label_plural' => 'CMS',
        'module_route' => 'playground.cms.resource',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-resource',
        'view' => 'playground-cms-resource',
    ];

    /**
     * Show the index.
     */
    public function index(): View
    {
        $packageInfo = $this->packageInfo();

        /**
         * @var view-string $view
         */
        $view = sprintf('%1$s::index', $packageInfo->view());

        return view($view, [
            'packageInfo' => $packageInfo,
        ]);
    }
}
