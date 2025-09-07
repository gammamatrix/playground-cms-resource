@extends(
    "playground::layouts.resource.form",
    [
        "withFormInfo" => "playground-cms-resource::page/form-info",
        "withFormStatus" => "playground-cms-resource::page/form-flags",
    ]
)

@section("form-tertiary")
    @include("playground-cms-resource::page/form-dates")
@endsection

@section("form-quaternary")
    @includeWhen(
        ! empty($_method) && "patch" === $_method,
        "playground-cms-resource::page/form-revisions"
    )
@endsection
