@extends('_templates.default')
@section('main')
<ul class="uk-breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="/">Transações</a></li>
    <li>
        <span>@if($transaction->id) Editar transação @else Nova transação @endif</span>
    </li>
</ul>
<h1 class="uk-heading">@if($transaction->id) Editar transação @else Nova transação @endif</h1>
<form method="POST" action="{{route('web.financial-transaction.save')}}" class="uk-form">
    <input type="hidden" name="id" value="{{$transaction->id ?? 0}}" />
    {{-- DESCRICAO --}}
    <div class="uk-margin">
        <label class="uk-form-label" for="description">Nome</label>
        <div class="uk-form-controls">
            <div class="uk-inline uk-width-1-1">
                <input class="uk-input {{$errors->first("description") ? "uk-form-danger" : ""}}" id="description" name='description' type="text" value="{{old("description", $transaction->description)}}">
            </div>
            @error('description')
            <span class="uk-text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
    {{-- VALUE --}}
    <div class="uk-margin">
        <label class="uk-form-label" for="value">Valor</label>
        <div class="uk-form-controls">
            <div class="uk-inline uk-width-1-1">
                <input class="uk-input {{$errors->first("value") ? "uk-form-danger" : ""}}" id="value" name='value' type="number" value="{{old("value", $transaction->value)}}">
            </div>
            @error('value')
            <span class="uk-text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
    {{-- DATE --}}
    <div class="uk-margin">
        <label class="uk-form-label" for="date">Data</label>
        <div class="uk-form-controls">
            <div class="uk-inline uk-width-1-1">
                <input class="uk-input {{$errors->first("date") ? "uk-form-danger" : ""}}" id="date" name='date' type="date" value="{{old("date", $transaction->date)}}">
            </div>
            @error('date')
            <span class="uk-text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="uk-text-right">
        <a href="{{route("web.financial-transaction.listView")}}" class="uk-button uk-button-default">Cancelar</a>
        <button class="uk-button uk-button-primary" type="submit">Salvar</button>
    </div>
    @csrf
</form>
@endsection