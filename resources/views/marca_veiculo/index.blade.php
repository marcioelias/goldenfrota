@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $marcaVeiculos, 
        'model' => 'marca_veiculo',
        'tableTitle' => 'Marca de Veículo',
        'displayField' => 'marca_veiculo',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection