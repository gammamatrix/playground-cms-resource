@extends (
    "playground::layouts.resource.form",
    [
        "withFormInfo" => "playground-cms-resource::page/form-info",
        "withFormAccess" => true,
    ]
)

@section ("form-quaternary")
    @includeWhen (
        ! empty($_method) && "patch" === $_method,
        "playground-cms-resource::page/form-revisions"
    )
@endsection
