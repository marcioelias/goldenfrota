@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Alterar Grupo de Serviço', 
            'routeUrl' => route('grupo_servico.update', $grupoServico->id), 
            'method' => 'PUT',
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
                            'autofocus' => true,
                            'inputValue' => $grupoServico->grupo_servico,
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection