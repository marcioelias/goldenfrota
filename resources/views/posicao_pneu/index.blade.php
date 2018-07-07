@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $posicoes, 
        'model' => 'posicao_pneu',
        'tableTitle' => 'Posição de Pneu',
        'displayField' => 'posicao_pneu',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection