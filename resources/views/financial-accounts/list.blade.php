@extends('_templates.default')
@section('main')
<h1 class="uk-heading">Contas</h1>
<a class="uk-button uk-button-primary" href="{{route("web.financial-account.addView")}}">Adicionar</a>
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
            <td>{{$account->description}}</td>
            <td>{{$account->type}}</td>
            <td>{{$account->currency}}</td>
            <td>{{number_format($account->current_balance, 2, ',', '.')}}</td>
            <td>{{number_format($account->expected_balance, 2, ',', '.')}}</td>
            <td class="uk-text-right">
                <a href="" class="uk-icon-link" uk-icon="star"></a>
                <a href="" class="uk-icon-link" uk-icon="pencil"></a>
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
@include("components.accounts.addmodal")
@endsection