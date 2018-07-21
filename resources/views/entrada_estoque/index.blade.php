@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $entradas, 
        'model' => 'entrada_estoque',
        'tableTitle' => 'Entradas no Estoque',
        'displayField' => 'nr_docto',
        'actions' => [['action' => 'show', 'target' => '_blank'], 'destroy']
        ]);
    @endcomponent
@endsection