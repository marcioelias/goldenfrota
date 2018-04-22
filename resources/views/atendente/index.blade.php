@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $atendentes, 
        'model' => 'atendente',
        'tableTitle' => 'Atendente',
        'displayField' => 'nome_atendente',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection