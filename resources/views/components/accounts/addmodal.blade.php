<div uk-modal id="addmodal">
    <div class="uk-modal-dialog">
        <form method="POST" action="{{route('web.financial-account.create')}}" class="uk-form">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Nova conta</h2>
            </div>
            <div class="uk-modal-body">
                {{-- DESCRICAO --}}
                <div class="uk-margin">
                    <label class="uk-form-label" for="description">Nome</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline uk-width-1-1">
                            <input class="uk-input {{$errors->first("description") ? "uk-form-danger" : ""}}" id="description" name='description' type="text" value="{{old("description")}}">
                        </div>
                        @error('description')
                        <span class="uk-text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                <button class="uk-button uk-button-primary" type="submit">Adicionar</button>
            </div>
            @csrf
        </form>
    </div>
</div>
