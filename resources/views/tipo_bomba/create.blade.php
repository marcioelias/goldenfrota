@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Novo Tipo de Bomba', 
            'routeUrl' => route('tipo_bomba.store'), 
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'tipo_bomba',
                            'label' => 'Tipo de Bomba',
                            'required' => true,
                            'autofocus' => true
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection