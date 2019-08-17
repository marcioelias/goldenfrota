@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Status de Ordem de Serviço', 
            'routeUrl' => route('ordem_servico_status.update', $ordemServicoStatus->id), 
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
                            'field' => 'os_status',
                            'label' => 'Status de Ordem de Serviço',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $ordemServicoStatus->os_status,
                            'inputSize' => 10
                        ],
                        [
                            'type' => 'select',
                            'field' => 'em_aberto',
                            'label' => 'Em aberto',
                            'inputSize' => 2,
                            'indexSelected' => $ordemServicoStatus->em_aberto,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection