@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $ajustes, 
        'model' => 'ajuste_tanque',
        'tableTitle' => 'Ajuste de Tanque',
        'displayField' => 'tanque',
        'actions' => ['destroy']
        ]);
    @endcomponent
@endsection