@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $movimentacoes, 
        'model' => 'tanque_movimentacao',
        'tableTitle' => 'Entrada de Combustíveis',
        'displayField' => 'documento',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection