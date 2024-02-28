@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-cms-resource::snippet/form-info',
    'withFormStatus' => 'playground-cms-resource::snippet/form-status',
])

@section('form-tertiary')
@include('playground-cms-resource::snippet/form-publishing')
@endsection

@section('form-quaternary')
@includeWhen(
    !empty($_method) && 'patch' === $_method,
    'playground-cms-resource::snippet/form-revisions'
)
@endsection
