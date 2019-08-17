@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $tipo_bombas, 
        'model' => 'tipo_bomba',
        'tableTitle' => 'Tipo de Bomba',
        'displayField' => 'tipo_bomba',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection