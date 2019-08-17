@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $entradas, 
        'model' => 'entrada_tanque',
        'tableTitle' => 'Entradas de Combustível',
        'displayField' => 'nr_docto',
        'actions' => [
            [
                'action' => 'show', 
                'target' => '_blank'
            ], 
            'destroy'
        ]]);
    @endcomponent
@endsection