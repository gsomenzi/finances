<div class="uk-margin">
    <label class="uk-form-label" for="{{$id ?? $name}}">{{$label}}</label>
    <div class="uk-form-controls">
        <div class="uk-inline uk-width-1-1">
            <input
                class="uk-input {{$error ? "uk-form-danger" : ""}}"
                id="{{$id ?? $name}}"
                name='{{$name}}'
                type="{{$type ?? 'text'}}"
                value="{{$value}}"
                @if(isset($type) && $type === 'number' && isset($step))
                step="{{$step}}"
                @endif
            />
        </div>
        @if($error)
        <span class="uk-text-danger">{{$error}}</span>
        @endif
    </div>
</div>