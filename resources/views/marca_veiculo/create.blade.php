@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Nova Marca de Veículo', 
            'routeUrl' => route('marca_veiculo.store'), 
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
                            'field' => 'marca_veiculo',
                            'label' => 'Marca de Veículo',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($marcaVeiculo->marca_veiculo) ? $marcaVeiculo->marca_veiculo: ''
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection