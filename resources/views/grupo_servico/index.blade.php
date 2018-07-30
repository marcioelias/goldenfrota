@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $grupoServicos, 
        'model' => 'grupo_servico',
        'tableTitle' => 'Grupo de Serviços',
        'displayField' => 'grupo_servico',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection