@extends('_templates.default')
@section('main')
<ul class="uk-breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="/">Lançamentos</a></li>
    <li>
        <span>@if($transaction->id) Editar lançamento @else Novo lançamento @endif</span>
    </li>
</ul>
<h1 class="uk-heading">@if($transaction->id) Editar lançamento @else Novo lançamento @endif</h1>
<form method="POST" action="{{route('web.financial-transaction.save')}}" class="uk-form">
    {{-- ID --}}
    <x-form.idfield :value="$transaction->id ?? 0" />
    {{-- DESCRICAO --}}
    <x-form.textfield
        name="description"
        label="Descrição"
        :value='old("description", $transaction->description)'
        :error='$errors->first("description")'
    />
    {{-- VALOR --}}
    <x-form.textfield
        name="value"
        label="Valor"
        type="number"
        :value='old("value", $transaction->value)'
        :error='$errors->first("value")'
        step="0.01"
    />
    {{-- DATA --}}
    <x-form.textfield
        name="date"
        label="Data"
        type="date"
        :value='old("date", \Carbon\Carbon::parse($transaction->date)->format("Y-m-d"))'
        :error='$errors->first("date")'
    />
    {{-- TIPO --}}
    <x-transaction.typeselectfield
        name="type"
        label="Tipo"
        :value='old("type", $transaction->type)'
        :error='$errors->first("type")'
    />
    {{-- PAGO --}}
    <x-form.checkboxfield
        name="paid"
        label="Pago"
        :checked='old("paid", $transaction->paid)'
        :error='$errors->first("paid")'
    />
    {{-- CATEGORIA --}}
    <x-form.selectfield
        name="category_id"
        label="Categoria"
        valueKey="id"
        labelKey="description"
        :options="$categories"
        :value='old("category_id", $transaction->category_id)'
        :error='$errors->first("category_id")'
    />
    {{-- CONTA --}}
    {{-- <x-form.selectfield
        name="financial_account_id"
        label="Conta"
        valueKey="id"
        labelKey="description"
        :options="$accounts"
        :value='old("financial_account_id", $transaction->financial_account_id)'
        :error='$errors->first("financial_account_id")'
    /> --}}
    {{-- FOOTER --}}
    <x-form.footer
        :cancelRoute='route("web.financial-transaction.listView")'
    />
</form>
@endsection
@section('script')
<script>
    function updateCategoriesList(selectedType = 'expense') {
        const categories = {!!$categories->toJson()!!};
        const selectCategory = $('.uk-select[name="category_id"]');
        const transactionCategory = {!!$transaction->category_id ?? 0!!};
        selectCategory.find('option').remove();
        categories.map(c => {
            if (c.destination === selectedType) {
                selectCategory.append(
                    `<option value="${c.id}" ${parseInt(c.id) === parseInt(transactionCategory) ? 'selected' : ''}>${c.description}</option>`
                );
            }
        });
    }

    const selectType = $('.uk-select[name="type"]');
    selectType.change(function () {
        const selectedType = $(this).val();
        updateCategoriesList(selectedType);
    });

    updateCategoriesList();
</script>
@endsection