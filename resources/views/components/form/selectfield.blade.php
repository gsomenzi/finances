@php
$componentId = "el".uniqid();
@endphp
<div class="uk-margin uk-custom-select" id="{{$componentId}}">
    {{-- LABEL --}}
    <label class="uk-form-label" for="{{$id ?? $name}}">{{$label}}</label>
    {{-- INPUT REAL --}}
    <input type="hidden" class="uk-select-realinput" name="{{$name}}" value="{{$value}}" />
    <div class="uk-form-controls">
        <div class="uk-inline uk-width-1-1">
            {{-- ICONE --}}
            <span class="uk-custom-select-icon uk-form-icon uk-form-icon-flip" uk-icon="icon: chevron-down"></span>
            {{-- INPUT FAKE --}}
            <input
                class="uk-input uk-select-fakeinput {{$error ? "uk-form-danger" : ""}}"
                id="{{$id ?? $name}}"
                @foreach($options as $option)
                    @if($option[$valueKey ?? "value"] === $value)
                        value="{{$option[$labelKey ?? "label"]}}"
                    @endif
                @endforeach
            />
            {{-- MENU --}}
            <div class="uk-custom-select-menu uk-box-shadow-small uk-border-rounded uk-width-1-1">
                @foreach($options as $option)
                <div data-value="{{$option[$valueKey ?? "value"]}}" class="uk-custom-select-item uk-padding-small">{{$option[$labelKey ?? "label"]}}</div>
                @endforeach
            </div>
        </div>
        {{-- ERRO --}}
        @if($error)
        <span class="uk-text-danger">{{$error}}</span>
        @endif
    </div>
</div>
@push("component_scripts")
<script>
    $("#{{$componentId}}").selectField();
</script>
@endpush