@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $combustiveis, 
        'model' => 'combustivel',
        'tableTitle' => 'Combustíveis',
        'displayField' => 'descricao',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection