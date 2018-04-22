@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $veiculos, 
        'model' => 'veiculo',
        'tableTitle' => 'Veiculos',
        'displayField' => 'placa',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection