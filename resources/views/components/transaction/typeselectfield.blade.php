@php
$typeOptions = [
    [
        "label" => "Receita",
        "value" => "receipt"
    ],
    [
        "label" => "Despesa",
        "value" => "expense"
    ]
];
@endphp

<x-form.selectfield
    name="type"
    label="Tipo"
    :value='$value'
    :options="$typeOptions"
    :error='$error'
/>