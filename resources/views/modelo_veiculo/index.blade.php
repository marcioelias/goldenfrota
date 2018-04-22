@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $modeloVeiculos, 
        'model' => 'modelo_veiculo',
        'tableTitle' => 'Modelo de Veículo',
        'displayField' => 'modelo_veiculo',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection