@extends('_templates.default')
@section('main')
<h1 class="uk-heading">Nova conta</h1>
<form method="POST" action="{{route('web.financial-account.create')}}" class="uk-form">
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
    {{-- SALDO INICIAL --}}
    <div class="uk-margin">
        <label class="uk-form-label" for="opening_balance">Saldo inicial</label>
        <div class="uk-form-controls">
            <div class="uk-inline uk-width-1-1">
                <input class="uk-input {{$errors->first("opening_balance") ? "uk-form-danger" : ""}}" id="opening_balance" name='opening_balance' type="number" value="{{old("opening_balance")}}">
            </div>
            @error('opening_balance')
            <span class="uk-text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="uk-margin">
        <label for="type" class="uk-form-label">Tipo</label>
        <select class="uk-select" value="{{old("type")}}" id="type" name="type">
            <option @if(old("type") === "checking") selected @endif value="checking">Conta corrente</option>
            <option @if(old("type") === "investiment") selected @endif value="investiment">Investimento</option>
            <option @if(old("type") === "other") selected @endif value="other">Outro</option>
        </select>
    </div>
    <div class="uk-text-right">
        <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
        <button class="uk-button uk-button-primary" type="submit">Adicionar</button>
    </div>
    @csrf
</form>
@endsection