<fieldset class="mb-3">

    <legend>Revisions</legend>

    <div class="row">
        <div class="col">

            @if (config('playground-cms-resource.revisions.optional'))

                <div class="form-check form-check-inline">
                    <input type="hidden" name="active" value="0">
                    <input class="form-check-input" type="checkbox" id="revision" name="revision" value="1"
                        {{ config('playground-cms-resource.revisions.snippets') ? 'checked' : '' }}>
                    <label class="form-check-label" for="revision">Revision</label>
                    <p class="form-text text-muted">
                        @if (config('playground-cms-resource.revisions.snippets'))
                            {{ __('playground-cms-resource::revisions.snippets.enabled') }}
                        @else
                            {{ __('playground-cms-resource::revisions.optional') }}
                        @endif
                    </p>
                </div>
            @else
                <p class="form-text text-muted">
                    @if (config('playground-cms-resource.revisions.snippets'))
                        {{ __('playground-cms-resource::revisions.snippets.enabled') }}
                    @else
                        {{ __('playground-cms-resource::revisions.snippets.disabled') }}
                    @endif
                </p>
            @endif

        </div>
    </div>

</fieldset>
