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
     * Show the index.
     */
    public function index(): View
    {
        return view('playground-cms-resource::index');
    }
}
