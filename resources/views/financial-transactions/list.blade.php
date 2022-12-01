@extends('_templates.default')
@section('main')
<ul class="uk-breadcrumb">
    <li><a href="/">Home</a></li>
    <li><span>Transações</span></li>
</ul>
<div class="uk-flex uk-flex-middle uk-flex-between">
    <h1 class="uk-heading uk-margin-remove-bottom">Transações</h1>
    <div class="uk-flex">
        <a class="uk-button uk-button-primary" href="{{route("web.financial-transaction.add")}}">Adicionar</a>
    </div>
</div>
@endsection