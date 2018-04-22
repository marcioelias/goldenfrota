@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $bombas, 
        'model' => 'bomba',
        'tableTitle' => 'Bombas',
        'displayField' => 'descricao_bomba',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection