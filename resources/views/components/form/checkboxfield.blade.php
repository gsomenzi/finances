<div class="uk-margin">
    <label for="{{$id ?? $name}}" class="uk-form-label">
        <input
            class="uk-checkbox"
            @if($checked ?? false) checked @endif id="{{$id ?? $name}}"
            name="{{$name}}"
            type="checkbox"
        />
        {{$label}}
    </label>
    @if($error)
    <span class="uk-text-danger">{{$error}}</span>
    @endif
</div>