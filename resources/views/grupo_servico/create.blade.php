@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Grupo de Serviço', 
            'routeUrl' => route('grupo_servico.store'), 
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
                            'field' => 'grupo_servico',
                            'label' => 'Grupo de Serviço',
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