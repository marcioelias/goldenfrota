@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $ordem_servico_status, 
        'model' => 'ordem_servico_status',
        'tableTitle' => 'Status de Ordem de Serviço',
        'displayField' => 'os_status',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection