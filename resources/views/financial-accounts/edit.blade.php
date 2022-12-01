@extends('_templates.default')
@section('main')
<ul class="uk-breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="/">Contas</a></li>
    <li>
        <span>@if($account->id) Editar conta @else Nova conta @endif</span>
    </li>
</ul>
<h1 class="uk-heading">@if($account->id) Editar conta @else Nova conta @endif</h1>
<form method="POST" action="{{route('web.financial-account.save')}}" class="uk-form">
    <input type="hidden" name="id" value="{{$account->id ?? 0}}" />
    {{-- DESCRICAO --}}
    <div class="uk-margin">
        <label class="uk-form-label" for="description">Nome</label>
        <div class="uk-form-controls">
            <div class="uk-inline uk-width-1-1">
                <input class="uk-input {{$errors->first("description") ? "uk-form-danger" : ""}}" id="description" name='description' type="text" value="{{old("description", $account->description)}}">
            </div>
            @error('description')
            <span class="uk-text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
    {{-- MOEDA --}}
    <div class="uk-margin">
        <x-currency-select :selected="old('currency', $account->currency)" />
        @error('currency')
        <span class="uk-text-danger">{{$message}}</span>
        @enderror
    </div>
    {{-- SALDO INICIAL --}}
    <div class="uk-margin">
        <label class="uk-form-label" for="opening_balance">Saldo inicial</label>
        <div class="uk-form-controls">
            <div class="uk-inline uk-width-1-1">
                <input class="uk-input {{$errors->first("opening_balance") ? "uk-form-danger" : ""}}" id="opening_balance" name='opening_balance' type="number" value="{{old("opening_balance", $account->opening_balance)}}">
            </div>
            @error('opening_balance')
            <span class="uk-text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="uk-margin">
        <label for="type" class="uk-form-label">Tipo</label>
        <select class="uk-select" value="{{old("type", $account->type)}}" id="type" name="type">
            <option @if(old("type", $account->type) === "checking") selected @endif value="checking">Conta corrente</option>
            <option @if(old("type", $account->type) === "investiment") selected @endif value="investiment">Investimento</option>
            <option @if(old("type", $account->type) === "other") selected @endif value="other">Outro</option>
        </select>
    </div>
    <div class="uk-text-right">
        <a href="{{route("web.financial-account.listView")}}" class="uk-button uk-button-default">Cancelar</a>
        <button class="uk-button uk-button-primary" type="submit">Salvar</button>
    </div>
    @csrf
</form>
@endsection