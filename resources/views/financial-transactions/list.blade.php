@extends('_templates.default')
@section('main')
<ul class="uk-breadcrumb">
    <li><a href="/">Home</a></li>
    <li><span>Lançamentos</span></li>
</ul>
<div class="uk-flex uk-flex-middle uk-flex-between">
    <h1 class="uk-heading uk-margin-remove-bottom">Lançamentos</h1>
    <div class="uk-flex">
        <a class="uk-button uk-button-primary" href="{{route("web.financial-transaction.add")}}">Adicionar</a>
    </div>
</div>
<table class="uk-table uk-table-divider uk-table-large">
    <thead>
        <tr>
            <th class="uk-table-shrink">#</th>
            <th>Descrição</th>
            <th>Conta</th>
            <th>Data</th>
            <th>Valor</th>
            <th class="uk-text-right">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            <td class="uk-table-shrink">{{$loop->iteration}}</td>
            <td class="uk-flex uk-flex-middle">
                {{$transaction->description}}
            </td>
            <td>{{$transaction->financialAccount->description}}</td>
            <td>{{$transaction->date->format('d/m/Y')}}</td>
            <td>
                <span class="uk-text-small">{{$transaction->financialAccount->currency}}</span>
                {{$transaction->type === 'expense' ? '-' : ''}}
                {{number_format($transaction->value, 2, ',', '.')}}
            </td>
            <td class="uk-text-right">
                @if(!$transaction->paid)
                <a href="{{route("web.financial-transaction.togglePaid", $transaction->id)}}" class="uk-icon-link uk-text-danger" uk-icon="close"></a>
                @else
                <a href="{{route("web.financial-transaction.togglePaid", $transaction->id)}}" class="uk-icon-link uk-text-success" uk-icon="check"></a>
                @endif
                <a href="{{route("web.financial-transaction.edit", $transaction->id)}}" class="uk-icon-link" uk-icon="pencil"></a>
                <a  
                    href="{{route("web.financial-transaction.remove", $transaction->id)}}"
                    class="uk-icon-link uk-text-danger confirmable"
                    data-confirm-text="Você tem certeza que deseja remover esta transação?"
                    uk-icon="trash">
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection