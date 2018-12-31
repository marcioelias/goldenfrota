@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Alterar Bico', 
            'routeUrl' => route('bico.update', $bico->id), 
            'method' => 'PUT',
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
                            'field' => 'num_bico',
                            'label' => 'N. Bico',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $bico->num_bico,
                            'inputSize' => 1
                        ],
                        [
                            'type' => 'select',
                            'field' => 'bomba_id',
                            'label' => 'Bomba',
                            'required' => true,
                            'items' => $bombas,
                            'inputSize' => 3,
                            'displayField' => 'descricao_bomba',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'indexSelected' => $bico->bomba_id
                        ],
                        [
                            'type' => 'select',
                            'field' => 'tanque_id',
                            'label' => 'Tanque',
                            'required' => true,
                            'items' => $tanques,
                            'inputSize' => 3,
                            'displayField' => 'descricao_tanque',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'indexSelected' => $bico->tanque_id
                        ],
                        [
                            'type' => 'text',
                            'field' => 'encerrante',
                            'label' => 'Encerrante',
                            'required' => true,
                            'inputValue' => $bico->encerrante,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'select',
                            'field' => 'permite_insercao',
                            'label' => 'Ins. Abast.',
                            'required' => true,
                            'indexSelected' => $bico->permite_insercao,
                            'items' => Array('Não', 'Sim'),
                            'inputSize' => 1
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $bico->ativo,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
    <script>
        $('document').ready(function() {
            $(encerrante).mask('000000000000000.000', {reverse: true});
        });
    </script>
@endsection