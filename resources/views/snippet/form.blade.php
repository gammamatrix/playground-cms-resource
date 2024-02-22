@extends('playground::layouts.resource.form', [
    'withFormInfo' => 'playground-cms-resource::snippet/form-info',
    'withFormStatus' => 'playground-cms-resource::snippet/form-status',
])

@section('form-tertiary')
@include('playground-cms-resource::snippet/form-publishing')
@endsection
