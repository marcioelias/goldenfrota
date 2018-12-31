@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Novo Grupo de Veículo', 
            'routeUrl' => route('grupo_veiculo.store'), 
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'ok'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'remove']
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'grupo_veiculo',
                            'label' => 'Grupo de Veículo',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($grupoVeiculo->grupo_veiculo) ? $grupoVeiculo->grupo_veiculo : ''
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection