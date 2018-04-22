@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $bicos, 
        'model' => 'bico',
        'tableTitle' => 'Bicos',
        'displayField' => 'num_bico',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection