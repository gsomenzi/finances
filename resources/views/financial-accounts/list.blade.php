@extends('_templates.default')
@section('main')
<div class="uk-flex uk-flex-middle uk-flex-between">
    <h1 class="uk-heading uk-margin-remove-bottom">Contas</h1>
    <div class="uk-flex">
        <a class="uk-button uk-button-primary" href="{{route("web.financial-account.add")}}">Adicionar</a>
    </div>
</div>
<table class="uk-table uk-table-divider uk-table-large">
    <thead>
        <tr>
            <th class="uk-table-shrink">#</th>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Moeda</th>
            <th>Saldo atual</th>
            <th>Saldo previsto</th>
            <th class="uk-text-right">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($accounts as $account)
        <tr>
            <td class="uk-table-shrink">{{$loop->iteration}}</td>
            <td class="uk-flex uk-flex-middle">
                {{$account->description}}
                @if($account->default)
                <a href="" class="uk-icon-link uk-text-warning uk-margin-small-left" uk-icon="star"></a>
                @endif
            </td>
            <td>{{$account->translated_type}}</td>
            <td>{{$account->currency}}</td>
            <td>
                <div>{{number_format($account->current_balance, 2, ',', '.')}}</div>
                @if($account->currency !== "BRL")
                <div class="uk-text-small">R$ {{number_format($account->converted_balance, 2, ',', '.')}}</div>
                @endif
            </td>
            <td>{{number_format($account->expected_balance, 2, ',', '.')}}</td>
            <td class="uk-text-right">
                @if(!$account->default)
                    <a href="{{route("web.financial-account.setAsDefault", $account->id)}}" class="uk-icon-link" uk-icon="star"></a>
                @endif
                <a href="{{route("web.financial-account.edit", $account->id)}}" class="uk-icon-link" uk-icon="pencil"></a>
                <a  
                    href="{{route("web.financial-account.remove", $account->id)}}"
                    class="uk-icon-link uk-text-danger confirmable"
                    data-confirm-text="Você tem certeza que deseja remover esta conta?"
                    uk-icon="trash">
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection