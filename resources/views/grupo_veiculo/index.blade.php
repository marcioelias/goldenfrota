@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $grupoVeiculos, 
        'model' => 'grupo_veiculo',
        'tableTitle' => 'Grupo de Veículo',
        'displayField' => 'grupo_veiculo',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection