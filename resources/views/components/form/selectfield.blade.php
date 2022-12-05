<div class="uk-margin">
    <label for="{{$id ?? $name}}" class="uk-form-label">{{$label}}</label>
    <select class="uk-select" value="{{$value}}" id="{{$id ?? $name}}" name="{{$name}}">
        @foreach($options as $option)
        <option
            @if($value === $option[$valueKey ?? "value"]) selected @endif
            value="{{$option[$valueKey ?? "value"]}}">
                {{$option[$labelKey ?? "label"]}}
        </option>
        @endforeach
    </select>
    @if($error)
    <span class="uk-text-danger">{{$error}}</span>
    @endif
</div>