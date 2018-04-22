@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $departamentos, 
        'model' => 'departamento',
        'tableTitle' => 'Departamentos',
        'displayField' => 'departamento',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection