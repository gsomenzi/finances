<div class="uk-text-right">
    @if(isset($cancelRoute))
    <a href="{{$cancelRoute}}" class="uk-button uk-button-default">{{$cancelLabel ?? "Cancelar"}}</a>
    @endif
    <button class="uk-button uk-button-primary" type="submit">{{$submitLabel ?? "Salvar"}}</button>
</div>
@csrf