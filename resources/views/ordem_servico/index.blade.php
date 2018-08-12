@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $ordem_servicos, 
        'model' => 'ordem_servico',
        'tableTitle' => 'Ordens de Serviço',
        'displayField' => 'id',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection