@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $servicos, 
        'model' => 'servico',
        'tableTitle' => 'Serviços',
        'displayField' => 'servico',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection