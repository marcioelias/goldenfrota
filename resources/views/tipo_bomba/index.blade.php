@extends('layouts.app')

@section('content')
@php
    $menuItems = [
        [
            'url' => '/admin/empresa',
            'rotulo' => 'Empresas'
        ],
        [
            'url' => '/admin/departamento',
            'rotulo' => 'Departamentos'
        ],
        [
            'url' => '/admin/perfil',
            'rotulo' => 'Perfis'
        ],
        [
            'url' => '/admin/horario',
            'rotulo' => 'Horários'
        ],
        [
            'url' => '/admin/plantonista',
            'rotulo' => 'Plantonistas'
        ],
        [
            'url' => '/admin/plantao',
            'rotulo' => 'Plantões'
        ],
    ]
@endphp
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