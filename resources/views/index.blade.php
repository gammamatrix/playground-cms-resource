@extends('playground::layouts.resource.layout')

@section('title', 'CMS')

@section('breadcrumbs')
<div class="container-fluid mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('playground.cms.resource') }}">CMS</a></li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card my-1">
                <div class="card-header">
                    <h1>CMS</h1>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Snippets</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage snippets</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.cms.resource.snippets') }}">View Snippets</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card m-1">
                                <div class="card-body">
                                    <h5 class="card-title">Pages</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Manage pages</h6>
                                    <p class="card-text"></p>
                                    <a class="card-link" href="{{ route('playground.cms.resource.pages') }}">View Pages</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
