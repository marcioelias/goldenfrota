@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $saidas, 
        'model' => 'saida_estoque',
        'tableTitle' => 'Saídas do Estoque',
        'displayField' => 'id',
        'actions' => [['action' => 'show', 'target' => '_blank'], 'destroy']
        ]);
    @endcomponent
@endsection