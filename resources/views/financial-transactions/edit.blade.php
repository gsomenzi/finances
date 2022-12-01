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
                <input
                    class="uk-input {{$errors->first("value") ? "uk-form-danger" : ""}}"
                    id="value"
                    name="value"
                    type="number"
                    value="{{old("value", $transaction->value)}}"
                    step="0.01"
                />
            </div>
            @error('value')
            <span class="uk-text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
    {{-- DATA --}}
    <div class="uk-margin">
        <label class="uk-form-label" for="date">Data</label>
        <div class="uk-form-controls">
            <div class="uk-inline uk-width-1-1">
                <input
                    class="uk-input {{$errors->first("date") ? "uk-form-danger" : ""}}"
                    id="date"
                    name="date"
                    type="date"
                    value="{{old("date", \Carbon\Carbon::parse($transaction->date)->format("Y-m-d"))}}"
                />
            </div>
            @error('date')
            <span class="uk-text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
    {{-- TIPO --}}
    <div class="uk-margin">
        <label for="type" class="uk-form-label">Tipo</label>
        <select class="uk-select" value="{{old("type", $transaction->type)}}" id="type" name="type">
            <option @if(old("type", $transaction->type) === "expense") selected @endif value="expense">Despesa</option>
            <option @if(old("type", $transaction->type) === "receipt") selected @endif value="receipt">Receita</option>
        </select>
    </div>
    {{-- PAGO --}}
    <div class="uk-margin">
        <label for="paid" class="uk-form-label">
            <input class="uk-checkbox" @if(old("paid", $transaction->paid)) checked @endif id="paid" name="paid" type="checkbox">
            Pago
        </label>
    </div>
    {{-- CATEGORIA --}}
    <div class="uk-margin">
        <label for="category_id" class="uk-form-label">Categoria</label>
        <select class="uk-select" value="{{old("category_id", $transaction->category_id)}}" id="category_id" name="category_id">
            @foreach($categories as $category)
                <option @if(old("category_id", $transaction->category_id) === $category->id) selected @endif value="{{$category->id}}">{{$category->description}}</option>
            @endforeach
        </select>
    </div>
    {{-- CONTA --}}
    <div class="uk-margin">
        <label for="financial_account_id" class="uk-form-label">Conta</label>
        <select class="uk-select" value="{{old("financial_account_id", $transaction->financial_account_id)}}" id="financial_account_id" name="financial_account_id">
            @foreach($accounts as $account)
                <option @if(old("financial_account_id", $transaction->financial_account_id) === $account->id) selected @endif value="{{$account->id}}">{{$account->description}}</option>
            @endforeach
        </select>
    </div>
    <div class="uk-text-right">
        <a href="{{route("web.financial-transaction.listView")}}" class="uk-button uk-button-default">Cancelar</a>
        <button class="uk-button uk-button-primary" type="submit">Salvar</button>
    </div>
    @csrf
</form>
@endsection
@section('script')
<script>
    const categories = {!!$categories->toJson()!!};
    const selectType = $('.uk-select[name="type"]');
    const selectCategory = $('.uk-select[name="category_id"]');
    selectType.change(function () {
        const selectedType = $(this).val();
        selectCategory.find('option').remove();
        categories.map(c => {
            if (c.destination === selectedType) {
                selectCategory.append(
                    `<option value="${c.id}">${c.description}</option>`
                );
            }
        });
    });
</script>
@endsection